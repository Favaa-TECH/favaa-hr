<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Console\Command;

class UpdatePresenceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-presence-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update presence status to Absent if no attendance recorded';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');
        $schedules = Schedule::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        foreach ($schedules as $schedule) {
            $shiftEndTime = Carbon::parse($schedule->end_date . ' ' . $schedule->shift->end_time);

            // Periksa apakah ada absensi yang sudah tercatat
            $attendance = Attendance::where('employee_id', $schedule->employee_id)
                ->where('check_in_date', $today)
                ->first();

            if (!$attendance) {
                // Jika belum ada absensi, tandai sebagai 'Absent' jika sudah melewati waktu shift
                if (Carbon::now() > $shiftEndTime) {
                    Attendance::create([
                        'employee_id' => $schedule->employee_id,
                        'check_out_time' => $shiftEndTime,
                        'check_out_date' => $today,
                        'status' => 'Absent',
                    ]);
                }
            }
        }

        $this->info('Absent status updated successfully.');
    }
}

<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Console\Command;

class UpdateAttendanceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-attendance-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $employees = Employee::all();
        $today = Carbon::today()->toDateString();

        foreach ($employees as $employee) {
            $employee->updateAttendanceStatus($today);
        }
    }
}

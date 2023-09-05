<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteAttendancePhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-attendance-photos';

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
        $this->info('Deleting attendance photos...');

        $attendancePhotos = glob(storage_path('app/public/attendance/photos/*'));

        foreach ($attendancePhotos as $attendancePhoto) {
            if (is_file($attendancePhoto)) {
                unlink($attendancePhoto);
            }
        }

        $this->info('Attendance photos deleted.');
    }
}

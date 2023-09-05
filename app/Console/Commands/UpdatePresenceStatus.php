<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Employee;
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
        $date = Carbon::today()->toDateString();
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $employee->updatePresenceStatus($date);
        }
    }
}

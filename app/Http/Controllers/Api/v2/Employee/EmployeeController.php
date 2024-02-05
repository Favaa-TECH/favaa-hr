<?php

namespace App\Http\Controllers\Api\v2\Employee;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function employeeDataDashboard()
    {
        try {
            $employee = Employee::with('position')->where('id', auth()->user()->employee_id)->first();
            $timeShift = Schedule::with('shift')->where('employee_id', auth()->user()->employee_id)->first();


            if (!$employee || !$timeShift) {
                return response()->json([
                    'code' => '404',
                    'status' => 'NOT_FOUND',
                    'message' => 'Data not found'
                ], 404);
            }
            return response()->json([
                'code' => '200',
                'status' => 'OK',
                'data' => [
                    'name' => $employee->name,
                    'photo' => 'storage/'.$employee->photo,
                    'position' => $employee->position->name,
                    'time_shift' => Carbon::parse($timeShift->shift->start_time)->format('H:i') . ' - ' . Carbon::parse($timeShift->shift->end_time)->format('H:i'),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '500',
                'status' => 'INTERNAL_SERVER_ERROR',
                'data' => $e->getMessage()
            ], 500);
        }
    }
}

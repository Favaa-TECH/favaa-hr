<?php

namespace App\Http\Controllers\Empl;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmplHistoryController extends Controller
{
    public function index() {
        $attendanceHistory = Attendance::where('employee_id',Auth::user()->employee_id)->latest()->paginate(10);
        return view('employee.history',[
            'attendanceHistory' => $attendanceHistory
        ]);
    }
}

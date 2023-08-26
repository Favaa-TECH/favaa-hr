<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('dashboard.schedule');
    }


}

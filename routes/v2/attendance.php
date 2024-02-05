<?php

use App\Http\Controllers\Api\v2\Attendance\AttendanceController;
use Illuminate\Support\Facades\Route;


Route::controller(AttendanceController::class)->group(function () {
    Route::get('v2/attendance/history/{countDay}', 'getAttendanceHistory');
    Route::get('v2/attendance/checkInToday', 'getCheckInToday');
    Route::get('v2/attendance/checkOutToday', 'getCheckOutToday');
    Route::get('v2/attendance/dataOutletemployee', 'getDataOutlet');
    Route::post('v2/attendance', 'store');
    Route::get('v2/attendance/canCheckInCheck', 'canCheckInCheck');
    Route::get('v2/attendance/canCheckOutCheck', 'canCheckOutCheck');
    Route::get('v2/attendance/isAlreadyCheckIn', 'isAlreadyCheckIn');
    Route::get('v2/attendance/isAlreadyPresent', 'isAlreadyPresent');
    Route::get('v2/attendance/checkSchedule', 'checkSchedule');

});



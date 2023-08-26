<?php

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAPI\AuthController;
use App\Http\Controllers\API\Leave\LeaveController;
use App\Http\Controllers\API\Attendance\AttendanceController;
use App\Http\Controllers\API\Permission\PermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function(){
        return Auth::user();
    });
    Route::get('/logout',[AuthController::class, 'logout']);
    Route::post('/attendance',[AttendanceController::class, 'store']);
    Route::get('/attendance/history',[AttendanceController::class, 'getAttendanceHistory']);
    Route::get('/attendance/check-out-today',[AttendanceController::class, 'getCheckOutToday']);
    Route::get('/attendance/check-in-today',[AttendanceController::class, 'getCheckInToday']);

    Route::post('/leave',[LeaveController::class, 'submitLeave']);
    Route::post('/permission',[PermissionController::class, 'submitPermission']);

});



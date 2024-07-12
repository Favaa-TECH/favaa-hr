<?php

use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAPI\AuthController;
use App\Http\Controllers\Api\Leave\LeaveController;
use App\Http\Controllers\Api\Attendance\AttendanceController;
use App\Http\Controllers\Api\Permission\PermissionController;

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
Route::get('/employee', [\App\Http\Controllers\Api\Employee\EmployeeController::class, 'getEmployee']);
Route::get('/position', [\App\Http\Controllers\Api\Position\PositionController::class, 'getPosition']);
Route::get('/attendance/recap', [\App\Http\Controllers\Api\Attendance\AttendanceController::class, 'getHistoryPA']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function(){
        return Auth::user();
    });
    Route::get('/logout',[AuthController::class, 'logout']);
    Route::post('/attendance',[AttendanceController::class, 'store']);
    Route::get('/attendance/{id}',[AttendanceController::class, 'getHistory']);
    Route::get('/attendance/history',[AttendanceController::class, 'getAttendanceHistory']);
    Route::get('/attendance/check-out-today',[AttendanceController::class, 'getCheckOutToday']);
    Route::get('/attendance/check-in-today',[AttendanceController::class, 'getCheckInToday']);

    Route::post('/leave',[LeaveController::class, 'store']);
    Route::post('/permission',[PermissionController::class, 'store']);


    require __DIR__.'/v2/attendance.php';
    require __DIR__.'/v2/employee.php';
    require __DIR__.'/v2/leave.php';
});






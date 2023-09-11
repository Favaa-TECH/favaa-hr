<?php

use App\Models\Leave;
use App\Livewire\Dashboard\Home;
use App\Livewire\Dashboard\Users;
use App\Livewire\Dashboard\Leaves;
use App\Livewire\Dashboard\Master;
use App\Livewire\Dashboard\Shifts;
use App\Livewire\Dashboard\Holidays;
use App\Livewire\Dashboard\Employees;
use App\Livewire\Dashboard\Schedules;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Attendances;
use App\Livewire\Dashboard\Permissions;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Employee\UserController;
use App\Http\Controllers\Master\OutletController;
use App\Http\Controllers\Empl\EmplLeaveController;
use App\Http\Controllers\Api\Leave\LeaveController;
use App\Http\Controllers\Master\PositionController;
use App\Http\Controllers\Attendance\ShiftController;
use App\Http\Controllers\Empl\EmplHistoryController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Attendance\HolidayController;
use App\Http\Controllers\Empl\EmplPermissionController;
use App\Http\Controllers\Attendance\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['guest'])->group(function () {
    Route::get('/login', AuthController::class . '@index')->name('login');
    Route::post('/login-authenticate', [AuthController::class, 'authenticate'])->name('login.authenticate');
});





Route::middleware(['auth'])->group(function () {

    Route::middleware(['userAccess:Administrator'])->group(function () {

        Route::get('/', Home::class)->name('home');
        Route::get('/employee', Employees::class)->name('employee');
        Route::get('/employee-add', EmployeeController::class . '@add')->name('employee.add');
        Route::post('/employee-store', EmployeeController::class . '@store')->name('employee.store');
        Route::delete('/employee-delete/{id}', EmployeeController::class . '@delete')->name('employee.delete');


        Route::get('/master', Master::class)->name('master.index');
        Route::post('/outlet-store', OutletController::class . '@store')->name('outlet.store');
        Route::post('/position-store', PositionController::class . '@store')->name('position.store');
        Route::delete('/outlet-delete/{id}', OutletController::class . '@delete')->name('outlet.delete');
        Route::delete('/position-delete/{id}', PositionController::class . '@delete')->name('position.delete');


        Route::get('/user', Users::class)->name('user.index');
        Route::post('/user-store', UserController::class . '@store')->name('user.store');
        Route::delete('/user-delete', UserController::class . '@delete')->name('user.delete');
        Route::get('/attendance', Attendances::class)->name('attendance.index');

        Route::get('/schedule',Schedules::class)->name('schedule.index');
        Route::get('/holiday',Holidays::class)->name('holiday.index');
        Route::post('/holiday-store',HolidayController::class.'@store')->name('holiday.store');
        Route::delete('/holiday-delete/{id}',HolidayController::class.'@delete')->name('holiday.delete');

        Route::get('/shift',Shifts::class)->name('shift.index');
        Route::post('/shift-store',ShiftController::class.'@store')->name('shift.store');

        Route::get('/leave',Leaves::class)->name('leave.index');
        Route::get('/permission',Permissions::class)->name('permission.index');

        Route::get('/generate-api-key',[\App\Http\Controllers\GenerateApiKey::class,'generateApiKey'])->name('generate-api-key');





    });

    Route::middleware(['userAccess:Employee'])->group(function () {
        Route::get('/empl-presence', AttendanceController::class . '@indexEmployee')->name('empl-presence');
        Route::get('/presence', AttendanceController::class . '@presence')->name('presence');
        Route::post('/presence-store', AttendanceController::class . '@store')->name('presence.store');
        Route::get('/empl-leave', EmplLeaveController::class . '@index')->name('empl-leave.index');
        Route::get('/empl-leave/submit-leave', EmplLeaveController::class . '@submit')->name('empl-leave.submit-leave');
        Route::post('/empl-leave/store', EmplLeaveController::class . '@store')->name('empl-leave.store');
        Route::get('/empl-permission',EmplPermissionController::class.'@index')->name('empl-permission.index');
        Route::get('/empl-permission/submit-permission',EmplPermissionController::class.'@submit')->name('empl-permission.submit-permission');
        Route::post('/empl-permission/store',EmplPermissionController::class.'@store')->name('empl-permission.store');
        Route::get('/empl-history',EmplHistoryController::class.'@index')->name('empl-history.index');
    });

    Route::post('/logout', AuthController::class . '@logout')->name('logout');
});

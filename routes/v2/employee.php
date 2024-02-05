<?php

use App\Http\Controllers\Api\v2\Employee\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::controller(EmployeeController::class)->group(function () {
    // Membuat route untuk employeeDataDashboard yang berfungsi untuk memenuhi kebutuhan data dashboard pada aplikasi Flutter
    Route::get('v2/employee/dashboardData', 'employeeDataDashboard');
});


?>

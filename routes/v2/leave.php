<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v2\Leave\LeaveController;

Route::controller(LeaveController::class)->group(function () {
    Route::post('v2/leave', 'store');
});


?>

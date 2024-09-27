<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);


Route::prefix('employee')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/store', [EmployeeController::class, 'store']);
    Route::post('/destroy', [EmployeeController::class, 'destroy']);
    Route::get('/show', [EmployeeController::class, 'show']);
    Route::post('/update', [EmployeeController::class, 'update']);
});

Route::prefix('leave')->group(function () {
    Route::post('/', [LeaveController::class, 'index']);
    Route::post('/request', [LeaveController::class, 'requestLeave']);
    Route::post('/manage', [LeaveController::class, 'manageLeave']);
});


Route::post('/logout', [AuthController::class, 'logout']);

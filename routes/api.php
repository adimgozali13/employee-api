<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('employee')->group(function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::post('/store', [EmployeeController::class, 'store']);
        Route::get('/show/{id}', [EmployeeController::class, 'show']);
        Route::post('/update/{id}', [EmployeeController::class, 'update']);
    });

    Route::prefix('leave')->group(function () {
        Route::get('/', [LeaveController::class, 'index']);
        Route::post('/request', [LeaveController::class, 'requestLeave']);
        Route::post('/manage/{id}', [LeaveController::class, 'manageLeave']);
    });


    Route::post('/logout', [AuthController::class, 'logout']);
});
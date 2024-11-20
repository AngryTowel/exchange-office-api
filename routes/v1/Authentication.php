<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::get('reset_password', [AuthController::class, 'resetPassword']);
    Route::post('reset_password', [AuthController::class, 'updatePassword']);

   // Authentication routes that requires previous authentication
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

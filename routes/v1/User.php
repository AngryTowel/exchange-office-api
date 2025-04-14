<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->middleware(['auth:sanctum'])->group(function () {
    // User CRUD
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::put('/', [UserController::class, 'update'])->name('user.update');

    Route::get('/organizations', [UserController::class, 'getOrganizations'])->name('user.organizations');
    // Update user password
    Route::post('/update_password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
});

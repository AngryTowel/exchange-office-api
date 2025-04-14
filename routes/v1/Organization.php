<?php

use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('/organization')->middleware(['auth:sanctum'])->group(function () {
    // Organization CRUD
    Route::get('/{organization_id}', [OrganizationController::class, 'index'])->name('organization.index');
    Route::put('/{organization_id}', [OrganizationController::class, 'update'])->name('organization.update');
});

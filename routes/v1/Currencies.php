<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CurrenciesController;
Route::prefix('/currencies')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/index', [CurrenciesController::class, 'index'])->name('currencies.index');
    Route::put('/', [CurrenciesController::class, 'update'])->name('currencies.edit');
    Route::post('/order', [CurrenciesController::class, 'order'])->name('currencies.order');

    Route::post('/history', [CurrenciesController::class, 'getHistory'])->name('currencies.getHistory');
});

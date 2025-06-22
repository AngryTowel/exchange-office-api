<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FormsController;

Route::prefix('forms')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/mt1', [FormsController::class, 'indexMT1'])->name('forms.indexMT1');
    Route::post('/mt1', [FormsController::class, 'createMT1'])->name('forms.createMT1');
    Route::put('/mt1', [FormsController::class, 'updateMT1'])->name('forms.updateMT1');
    Route::delete('/mt1/{id}', [FormsController::class, 'deleteMT1'])->name('forms.deleteMT1');
    Route::post('/mt1/pdf', [FormsController::class, 'pdfMT1'])->name('forms.pdfMT1');
    Route::post('/mt1/randomize', [FormsController::class, 'randomizeMT1'])->name('forms.randomizeMT1');

    Route::get('/kt1', [FormsController::class, 'index1KT'])->name('forms.index1KT');
    Route::post('/kt1', [FormsController::class, 'create1KT'])->name('forms.create1KT');
    Route::delete('/kt1/{id}', [FormsController::class, 'delete1KT'])->name('forms.delete1KT');
    Route::post('/kt1/pdf', [FormsController::class, 'pdfKT1'])->name('forms.pdfKT1');
});

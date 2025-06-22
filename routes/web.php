<?php

use Illuminate\Support\Facades\Route;

Route::fallback(function () {
    return redirect('https://menuvacnica.e-rahimov.com', 301);
});

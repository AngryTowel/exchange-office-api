<?php

namespace App\Providers;

use App\Models\CurrencyValueHistory;
use App\Models\Form1KT;
use App\Models\FormMT1;
use App\Observers\Forms\Form1KTObserver;
use App\Observers\Forms\MT1FormObserver;
use App\Observers\Global\CustomId;
use Illuminate\Support\ServiceProvider;

class ModelObserversProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        FormMT1::observe([CustomId::class, MT1FormObserver::class]);
        Form1KT::observe([CustomId::class, Form1KTObserver::class]);
        CurrencyValueHistory::observe(CustomId::class);
    }
}

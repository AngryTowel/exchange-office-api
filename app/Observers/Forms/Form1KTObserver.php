<?php

namespace App\Observers\Forms;

use App\Models\Currencies;
use App\Models\CurrencyValueHistory;
use App\Models\Form1KT;
use App\Models\Organization;
use App\Services\Organization\Interfaces\CurrencyServiceInterface;
use Carbon\Carbon;

class Form1KTObserver
{
    public function __construct(
        protected CurrencyServiceInterface $currency_service
    ) {}
    /**
     * Handle the Form1KT "created" event.
     * Calculate the values in the history tracking.
     */
    public function created(Form1KT $form1KT): void
    {
        $this->currency_service->calculateHistoryFrom1KT($form1KT->fresh());
    }
    /**
     * Handle the Form1KT "updated" event.
     */
    public function updated(Form1KT $form1KT): void
    {
        //
    }

    /**
     * Handle the Form1KT "deleted" event.
     */
    public function deleted(Form1KT $form1KT): void
    {
        //
    }

    /**
     * Handle the Form1KT "restored" event.
     */
    public function restored(Form1KT $form1KT): void
    {
        //
    }

    /**
     * Handle the Form1KT "force deleted" event.
     */
    public function forceDeleted(Form1KT $form1KT): void
    {
        //
    }
}

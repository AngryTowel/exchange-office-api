<?php

namespace App\Observers\Forms;

use App\Models\Form1KT;
use App\Services\Organization\Interfaces\CurrencyServiceInterface;

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
        if ($form1KT->wasChanged(['date_time', 'exchange_amount_input', 'exchange_amount_output', 'rate', 'value_input', 'value_output'])) {
            $originalModel = new Form1KT();
            $originalModel->forceFill($form1KT->getOriginal());
            $this->currency_service->calculateHistoryFrom1KT($originalModel, reverse: true);
            $this->currency_service->calculateHistoryFrom1KT($form1KT);
        }
    }

    /**
     * Handle the Form1KT "deleted" event.
     */
    public function deleted(Form1KT $form1KT): void
    {
        $this->currency_service->calculateHistoryFrom1KT($form1KT, reverse: true);
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

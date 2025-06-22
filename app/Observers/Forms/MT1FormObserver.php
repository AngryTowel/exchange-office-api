<?php

namespace App\Observers\Forms;

use App\Enums\Forms\TypesEnum;
use App\Models\Form1KT;
use App\Models\FormMT1;
use Carbon\Carbon;

class MT1FormObserver
{
    /**
     * Handle the FormMT1 "created" event.
     * Automatically create a 1KT form with code 10 for buying and code 12 for selling
     */
    public function created(FormMT1 $formMT1): void
    {
        Form1KT::query()->create([
            'organization_id' => $formMT1->organization_id,
            'user_id' => $formMT1->user_id,
            'document_no' => $formMT1->custom_id,
            'description' => TypesEnum::toKT1(TypesEnum::from($formMT1->type)),
            'currency_type' => $formMT1->currency_type,
            'date_time' => $formMT1->date_time,
            'exchange_amount_input' => TypesEnum::from($formMT1->type) === TypesEnum::buying ? $formMT1->exchange_amount : 0,
            'exchange_amount_output' => TypesEnum::from($formMT1->type) === TypesEnum::selling ? $formMT1->exchange_amount : 0,
            'rate' => $formMT1->rate,
            'funds_type' => '',
            'value_input' => TypesEnum::from($formMT1->type) === TypesEnum::buying ? 0 : $formMT1->value,
            'value_output' => TypesEnum::from($formMT1->type) === TypesEnum::selling ? 0 : $formMT1->value,
            'authorized_bank' => $formMT1->authorized_bank
        ]);
    }

    /**
     * Handle the FormMT1 "updated" event.
     */
    public function updated(FormMT1 $formMT1): void
    {
        // The KT1 should always be retrieved by the original values and then change accordingly.
        $original_custom_id = $formMT1->getOriginal()['custom_id'];
        $original_date_time = $formMT1->getOriginal()['date_time'];

        $ktForm = Form1KT::query()
            ->where('document_no', $original_custom_id)
            ->whereYear('date_time', Carbon::createFromDate($original_date_time)->year)
            ->first();

        $ktForm->update([
            'document_no' => $formMT1->custom_id,
            'description' => TypesEnum::toKT1(TypesEnum::from($formMT1->type)),
            'currency_type' => $formMT1->currency_type,
            'date_time' => $formMT1->date_time,
            'exchange_amount_input' => TypesEnum::from($formMT1->type) === TypesEnum::buying ? $formMT1->exchange_amount : 0,
            'exchange_amount_output' => TypesEnum::from($formMT1->type) === TypesEnum::selling ? $formMT1->exchange_amount : 0,
            'rate' => $formMT1->rate,
            'value_input' => TypesEnum::from($formMT1->type) === TypesEnum::buying ? 0 : $formMT1->value,
            'value_output' => TypesEnum::from($formMT1->type) === TypesEnum::selling ? 0 : $formMT1->value,
            'authorized_bank' => $formMT1->authorized_bank
        ]);
    }

    /**
     * Handle the FormMT1 "deleted" event.
     */
    public function deleted(FormMT1 $formMT1): void
    {
        Form1KT::query()
            ->where('document_no', $formMT1->custom_id)
            ->whereYear('date_time', Carbon::createFromDate($formMT1->date_time)->year)
            ->first()
            ->delete();
    }

    /**
     * Handle the FormMT1 "restored" event.
     */
    public function restored(FormMT1 $formMT1): void
    {
        //
    }

    /**
     * Handle the FormMT1 "force deleted" event.
     */
    public function forceDeleted(FormMT1 $formMT1): void
    {
        //
    }
}

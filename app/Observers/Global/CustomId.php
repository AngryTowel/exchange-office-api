<?php

namespace App\Observers\Global;

use App\Models\Form1KT;
use App\Models\FormMT1;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomId
{
    /**
     * Handle the Record "creating" event.
     *
     * @param  Model  $model
     * @return void
     */
    public function creating(Model $model): void
    {
        if ($model instanceof FormMT1) {
            $maxCustomId = $model::query()->where('organization_id', $model->organization_id)
                ->whereYear('date_time', Carbon::parse($model->date_time)->year)
                ->max('custom_id');
        } else if ($model instanceof Form1KT) {
            $maxCustomId = $model::where('organization_id', $model->organization_id)
                ->whereDate('date_time', Carbon::parse($model->date_time)->format('Y-m-d'))
                ->max('custom_id');
        } else {
            $maxCustomId = $model::where('organization_id', $model->organization_id)
                ->max('custom_id');
        }

        $model->custom_id = $maxCustomId + 1;
    }
}

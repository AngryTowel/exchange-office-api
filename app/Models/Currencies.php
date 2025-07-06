<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasOne};

class Currencies extends Model
{
    protected $fillable = [
        'code',
        'name',
        'country',
        'currency',
        'buying_rate',
        'selling_rate',
        'organization_id',
        'isDefault',
        'order'
    ];

    protected $casts = [
        "name" => "array",
        "country" => "array"
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    public function valueHistories(): HasMany
    {
        return $this->hasMany(CurrencyValueHistory::class, 'currency_id');
    }
    public function value(): HasOne
    {
        return $this->hasOne(CurrencyValueHistory::class, 'currency_id')
            ->latestOfMany();
    }

    public function kt1Forms(): HasMany
    {
        return $this->hasMany(Form1KT::class, 'currency_type', 'currency')
            ->whereColumn('organization_id', '=', 'form_1kt_s.organization_id');
    }

}

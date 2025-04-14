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
        'course',
        'organization_id',
        'isDefault'
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

}

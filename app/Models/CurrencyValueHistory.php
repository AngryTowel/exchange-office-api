<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyValueHistory extends Model
{
    // This is the 1DB Form
    protected $table = 'form_1db_s';
    protected $fillable = [
        'custom_id',
        'organization_id',
        'currency_id',
        'initial_value',
        'input',
        'output',
        'value',
        'created_at',
        'updated_at'
    ];

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currencies::class);
    }
}

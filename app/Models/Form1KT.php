<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Form1KT extends Model
{
    protected $table = 'form_1kt_s';

    protected $fillable = [
        'organization_id',
        'custom_id',
        'user_id',
//        'exchange_office',
//        'exchange_office_id',
//        'exchange_office_address',
        'date_time',
        'document_no',
        'description',
        'currency_type',
        'exchange_amount_input',
        'exchange_amount_output',
        'rate',
        'funds_type',
        'value_input',
        'value_output',
        'authorized_bank',
        'currency_id',
        'form_mt1_id'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function formMT1(): BelongsTo
    {
        return $this->belongsTo(FormMT1::class, 'form_mt1_id');
    }
}

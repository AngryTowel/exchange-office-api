<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormMT1 extends Model
{
    protected $table = 'form_mt1_s';
    protected $fillable = [
//        'exchange_office',
        'user_id',
        'custom_id',
        'organization_id',
        'authorized_bank',
        'date_time',
        'type',
        'currency_type',
        'exchange_amount',
        'rate',
        'value',
        'residency',
        'exchange_id',
        'authorized_person'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'exchange_id' => 'encrypted',
        ];
    }
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
    public function form1KT(): BelongsTo
    {
        return $this->belongsTo(Form1KT::class, 'custom_id', 'document_no')
            ->whereColumn('date_time', '=', 'form_1kt_s.date_time');
    }
}

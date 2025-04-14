<?php

namespace App\Models;

use App\Enums\Organization\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'address',
        'owner_id',
        'office_id'
    ];

    protected $casts = [
        'status' => StatusEnum::class,
        'exchange_id' => 'encrypted'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function currencies(): HasMany
    {
        return $this->hasMany(Currencies::class, 'organization_id');
    }
    public function mainCurrency(): HasOne
    {
        return $this->hasOne(Currencies::class, 'organization_id')->where('isDefault', true);
    }
}

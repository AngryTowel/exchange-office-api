<?php

namespace App\Http\Resources\Currency;

use App\Models\CurrencyValueHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin CurrencyValueHistory */
class CurrencyValueHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'initial_value' => $this['initial_value'],
            'input' => $this['input'],
            'output' => $this['output'],
            'value' => $this['value'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at'],

        ];
    }
}

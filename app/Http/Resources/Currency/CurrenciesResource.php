<?php

namespace App\Http\Resources\Currency;

use App\Http\Resources\Organization\OrganizationResource;
use App\Models\Currencies;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin Currencies */
class CurrenciesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'country' => $this->country,
            'currency' => $this->currency,
            'buying_rate' => $this->buying_rate,
            'selling_rate' => $this->selling_rate,
            'has_value' => $this->valueHistories()->exists(),
            'isDefault' => $this->isDefault,
            'value_history' => CurrencyValueHistoryResource::collection($this->whenLoaded('valueHistories')),
            'organization' => new OrganizationResource($this->whenLoaded('organization')),
            'current_value' => new CurrencyValueHistoryResource($this->whenLoaded('value')),
        ];
    }
}

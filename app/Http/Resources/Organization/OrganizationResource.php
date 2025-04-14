<?php

namespace App\Http\Resources\Organization;

use App\Http\Resources\Currency\CurrenciesResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'name' => $this->name,
            'address' => $this->address,
            'exchange_id' => $this->exchange_id,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'main_currency' => new CurrenciesResource($this->whenLoaded('mainCurrency')),
        ];
    }
}

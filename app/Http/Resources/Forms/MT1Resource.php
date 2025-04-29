<?php

namespace App\Http\Resources\Forms;

use App\Http\Resources\Organization\OrganizationResource;
use App\Models\FormMT1;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin FormMT1 */
class MT1Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->custom_id,
            'exchange_office' => new OrganizationResource($this->whenLoaded('organization')),
            'authorized_bank' => $this->authorized_bank,
            'date_time' => $this->date_time,
            'type' => $this->type,
            'currency_type' => $this->currency_type,
            'exchange_amount' => $this->exchange_amount,
            'rate' => $this->rate,
            'value' => $this->value,
            'residency' => $this->residency,
            'exchange_id' => $this->exchange_id,
            'authorized_person' => $this->authorized_person
        ];
    }
}

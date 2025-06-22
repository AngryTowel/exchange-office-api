<?php

namespace App\Http\Resources\Forms;

use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Resources\User\UserResource;
use App\Models\Form1KT;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/** @mixin Form1KT */
class KT1Resource extends JsonResource
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
            'custom_identifier' => $this->custom_id,
            'exchange_office' => new OrganizationResource($this->whenLoaded('organization')),
            'date_time' => $this->date_time,
            'document_no' => $this->document_no,
            'description' => $this->description,
            'currency_type' => $this->currency_type,
            'exchange_amount_input' => $this->exchange_amount_input,
            'exchange_amount_output' => $this->exchange_amount_output,
            'rate' => $this->rate,
            'funds_type' => $this->funds_type,
            'value_input' => $this->value_input,
            'value_output' => $this->value_output,
            'authorized_bank' => $this->authorized_bank,
            'user' => new UserResource($this->whenLoaded('user')),
            'mt1' => new MT1Resource($this->whenLoaded('formMT1')),
            'hasMT1' => $this->formMT1()->exists()
        ];
    }
}

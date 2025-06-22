<?php

namespace App\Http\Requests\Forms;

use App\Enums\Forms\ResidencyEnum;
use App\Enums\Forms\TypesEnum;
use App\Rules\Organizations\IsPartOfOrganization;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RandomizeMT1Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'authorized_bank' => 'nullable',
            'date_from' => ['required', 'date_format:Y-m-d'],
            'date_to' => ['required', 'date_format:Y-m-d'],
            'type' => ['required', Rule::enum(TypesEnum::class)],
            'currency_type' => ['required', 'exists:currencies,currency'],
            'rate' => ['required', 'numeric', 'gt:0'],
            'exchange_total' => ['required', 'numeric', 'gt:0'],
            'residency' => ['required', Rule::enum(ResidencyEnum::class)],
            'authorized_person' => ['required', 'string'],
            'organization_id' => ['required', new IsPartOfOrganization()],
        ];
    }
}

<?php

namespace App\Http\Requests\Forms;

use App\Enums\Forms\ResidencyEnum;
use App\Enums\Forms\TypesEnum;
use App\Rules\Organizations\IsPartOfOrganization;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMT1Request extends FormRequest
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
            'date_time' => ['required', 'date_format:Y-m-d H:i'],
            'type' => ['required', Rule::enum(TypesEnum::class)],
            'currency_type' => ['required', 'exists:currencies,currency'],
            'exchange_amount' => ['required', 'numeric', 'gt:0'],
            'course' => ['required', 'numeric', 'gt:0'],
            'residency' => ['required', Rule::enum(ResidencyEnum::class)],
            'authorized_person' => ['required', 'string'],
            'exchange_id' => ['nullable'],
            'organization_id' => ['required', new IsPartOfOrganization()],
        ];
    }


}

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
            'rate' => ['required', 'numeric', 'gt:0'],
            'exchange_amount' => ['required', 'numeric', 'gt:0'],
            'residency' => ['required', Rule::enum(ResidencyEnum::class)],
            'authorized_person' => ['required', 'string'],
            'exchange_id' => ['nullable'],
            'organization_id' => ['required', new IsPartOfOrganization()],
        ];
    }
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $exchangeAmount = $this->input('exchange_amount');
            $rate = $this->input('rate');

            if ($exchangeAmount !== null && $rate !== null) {
                $total = $exchangeAmount * $rate;

                if ($total >= 30000 && empty($this->input('exchange_id'))) {
                    $validator->errors()->add('exchange_id', 'errors.forms.id_required');
                }
            }
        });
    }

}

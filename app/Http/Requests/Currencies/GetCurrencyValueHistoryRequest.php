<?php

namespace App\Http\Requests\Currencies;

use App\Rules\Currencies\CanUpdate;
use App\Rules\Organizations\IsPartOfOrganization;
use Illuminate\Foundation\Http\FormRequest;

class GetCurrencyValueHistoryRequest extends FormRequest
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
            'id' => ['nullable', 'array'], // The can update validator can be used to check if the user can access the resource
            'id.*' => ['required', 'exists:currencies,id', new CanUpdate()],
            'organization_id' => ['required', 'exists:organizations,id', new IsPartOfOrganization()],
            'from_date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}

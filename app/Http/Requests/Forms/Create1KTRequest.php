<?php

namespace App\Http\Requests\Forms;

use App\Rules\Organizations\IsPartOfOrganization;
use Illuminate\Foundation\Http\FormRequest;

class Create1KTRequest extends FormRequest
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
            'authorized_bank' => ['nullable'],
            'document_no' => ['nullable'],
            'currency_type' => ['required', 'exists:currencies,currency'],
            'rate' => ['required', 'numeric', 'gte:0'],
            'date_time' => ['required', 'date_format:Y-m-d H:i'],
            'organization_id' => ['required', new IsPartOfOrganization()],
            'description' => ['required', 'gte:10', 'lte:23'],
            'exchange_amount_input' => ['required', 'numeric', 'gte:0'],
            'exchange_amount_output' => ['required', 'numeric', 'gte:0'],
            'funds_type' => ['nullable', 'string'],
            'value_input' => ['required', 'numeric', 'gte:0'],
            'value_output' => ['required', 'numeric', 'gte:0'],
        ];
    }
}

<?php

namespace App\Http\Requests\Currencies;

use App\Rules\Organizations\IsPartOfOrganization;
use Illuminate\Foundation\Http\FormRequest;

class GetHistoryPDFRequest extends FormRequest
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
            'organization_id' => ['required', 'integer', 'exists:organizations,id', new IsPartOfOrganization()],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}

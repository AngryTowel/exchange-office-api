<?php

namespace App\Http\Requests\Forms;

use App\Rules\Organizations\IsPartOfOrganization;
use Illuminate\Foundation\Http\FormRequest;

class PdfIMR1Request extends FormRequest
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
            'date_from' => ['required', 'date_format:Y-m-d'],
            'date_to' => ['required', 'date_format:Y-m-d'],
            'organization_id' => ['required', 'exists:organizations,id', new IsPartOfOrganization()]
        ];
    }
}

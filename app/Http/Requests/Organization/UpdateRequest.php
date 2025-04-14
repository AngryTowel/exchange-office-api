<?php

namespace App\Http\Requests\Organization;

use App\Rules\Organizations\IsPartOfOrganization;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'organization_id' => ['required', 'exists:organizations,id', new IsPartOfOrganization()],
            'current_value' => ['nullable', 'numeric', 'min:0'],
            'name' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'exchange_id' => ['nullable', 'string']
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'organization_id' => $this->route('organization_id')
        ]);
    }
}

<?php

namespace App\Http\Requests\Currencies;

use App\Rules\Currencies\CanUpdate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrenciesRequest extends FormRequest
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
            '*.name' => 'nullable|string',
            '*.course' => 'nullable|numeric',
            '*.current_value' => 'nullable|numeric',
            '*.id' => ['required', 'exists:currencies,id', new CanUpdate()],
        ];
    }
}

<?php

namespace App\Http\Requests\Currencies;

use App\Rules\Currencies\CanUpdate;
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
            'id' => ['required', 'exists:currencies,id', new CanUpdate()], // The can update validator can be used to check if the user can access the resource
            'from_date' => ['required', 'date', 'date_format:Y-m-d'],
            'to_date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}

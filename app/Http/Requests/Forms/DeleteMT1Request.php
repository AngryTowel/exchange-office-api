<?php

namespace App\Http\Requests\Forms;

use App\Models\FormMT1;
use App\Rules\Forms\CanUpdate;
use Illuminate\Foundation\Http\FormRequest;

class DeleteMT1Request extends FormRequest
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
            'id' => ['required', 'integer', 'exists:form_mt1_s,id', new CanUpdate(FormMT1::class)],
        ];
    }
    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }
}

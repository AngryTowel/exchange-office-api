<?php

namespace App\Http\Requests\Forms;

use App\Models\Form1KT;
use App\Rules\Forms\CanUpdate;
use Illuminate\Foundation\Http\FormRequest;

class Delete1KTRequest extends FormRequest
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
            'id' => ['required', 'integer', 'exists:form_1kt_s,id', new CanUpdate(Form1KT::class)],
        ];
    }
    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }
}

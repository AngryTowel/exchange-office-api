<?php

namespace App\Http\Requests\User;

use App\Rules\Auth\CurrentPasswordRule;
use App\Rules\Auth\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => ['required', 'string', new CurrentPasswordRule],
            'password' => ['string', 'required', 'confirmed', 'min:8', new PasswordRule()]
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'errors.auth.password.required',
            'password.min' => 'errors.auth.password.not_enough_characters',
            'password.regex' => 'errors.auth.password.requirements'
        ];
    }
}

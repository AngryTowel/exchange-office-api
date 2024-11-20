<?php

namespace App\Rules\Auth;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Define the regex for the password rule
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/';

        // Check if the value matches the pattern
        if (!preg_match($pattern, $value)) {
            // If validation fails, trigger the error message
            $fail('The password must contain at least one lowercase letter, one uppercase letter, one number and one special character');
        }
    }
}

<?php

namespace App\Rules\Organizations;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class IsPartOfOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->organizations()->where('organization_id', $value)->exists()) {
            $fail('error.organization.forbidden');
        }
    }
}

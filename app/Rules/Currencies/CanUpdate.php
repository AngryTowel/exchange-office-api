<?php

namespace App\Rules\Currencies;

use App\Models\Currencies;
use App\Repositories\User\UserRepository;
use App\Rules\Organizations\IsPartOfOrganization;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class CanUpdate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $currency = Currencies::find($value);

        $validator = new IsPartOfOrganization();
        $validator->validate('org_id', $currency->organization_id, $fail);
    }
}

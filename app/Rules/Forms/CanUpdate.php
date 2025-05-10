<?php

namespace App\Rules\Forms;

use App\Rules\Organizations\IsPartOfOrganization;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CanUpdate implements ValidationRule
{
    /**
     * Model::class
     *
     */
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $form = $this->model::find($value);

        $validator = new IsPartOfOrganization();
        $validator->validate('org_id', $form->organization_id, $fail);
    }
}

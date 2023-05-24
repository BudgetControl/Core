<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\BudgetTracker\Enums\AccountType as AccountEnums;

class AccountType implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = false;
        foreach(AccountEnums::cases() as $case) {
            if ($value == $case->value) {
                $result = true;
            }
        }

        if($result === false) {
            $fail('The :attribute must one of existing type');
        }
    }
}

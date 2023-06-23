<?php

namespace App\Rules\Account;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\BudgetTracker\Constants\Currency;
use App\BudgetTracker\Enums\AccountType as AccountEnums;

class AccountCurrencyValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = false;
        
        if(array_key_exists($value,Currency::data)) {
            $result = true;
        }

        if($result === false) {
            $fail('The :attribute must one of existing type');
        }
    }
}

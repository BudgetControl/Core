<?php

namespace App\Rules\Account;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\BudgetTracker\Enums\AccountType as AccountEnums;

class AccountColorValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = true;
        
         $code = str_replace(' ', '', $value);
         $code = str_replace('#', '', $value);

         if (strlen($code) !== 6) {
             $result = false;
         }
 
         if (!ctype_xdigit($code)) {
            $result = false;
         }
 
        if($result === false) {
            $fail('The :attribute must be a valid exadecimal code');
        }
    }
}

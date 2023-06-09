<?php

namespace App\BudgetTracker\ValueObject\Accounts;

use App\BudgetTracker\Enums\AccountType;
use App\BudgetTracker\Constants\Currency;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\Rules\Account\AccountTypeValidation;
use App\Rules\Account\AccountColorValidation;
use App\Rules\Account\AccountCurrencyValidation;
use DateTime;

final class CreditCardAccount extends Account {


    public function __construct(string $name, string $currency, string $color, float $balance, DateTime $date, bool $installement, float $installementValue = 0)
    {

        $this->name = $name;
        $this->type = AccountType::CreditCard;
        $this->currency = $currency;
        $this->balance = $balance;
        $this->color = $color;
        $this->installement = $installement;
        $this->installementValue = $installementValue;
        $this->date = $date->format('Y-m-d h:i:s');

        if($installement === true) {
            $this->installementValidate();
        }
        
        $this->validate();

    }
    
    private function hash(): string
    {
        return md5("{$this->name}{$this->currency}{$this->color}{$this->balance}{$this->type->value}{$this->installement}{$this->installementValue}{$this->date}");
    }

    /**
     * Get the value of value
     */ 
    public function getBalance()
    {
        return $this->balance;
    }

    public function isEqualsTo(CreditCardAccount $account): bool
    {
        return $this->hash() === $account->hash();
    }

    /**
     * validate a installement type
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function installementValidate(): void
    {
        $rules = [
            'installement' => ['required','true'],
            'installementValue' => ['required','numeric'],
        ];

        Validator::validate($this->toArray(), $rules);
    }

        /**
     * read a resource
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    private function validate(): void
    {
        $rules = [
            'name' => ['required', 'string'],
            'type' => ['required', new AccountTypeValidation()],
            'color' => ['required',new AccountColorValidation()],
            'currency' => ['required', new AccountCurrencyValidation()],
            'date' => ['date', 'date_format:Y-m-d H:i:s', 'required'],
            'balance' =>  ['required','numeric'],
        ];

        Validator::validate($this->toArray(), $rules);
    }
}
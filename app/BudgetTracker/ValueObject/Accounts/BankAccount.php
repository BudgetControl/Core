<?php

namespace App\BudgetTracker\ValueObject\Accounts;

use App\BudgetTracker\Enums\AccountType;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\Rules\Account\AccountTypeValidation;
use App\Rules\Account\AccountColorValidation;
use App\Rules\Account\AccountCurrencyValidation;

use DateTime;

final class BankAccount extends Account {

    public function __construct(string $name, string $currency, string $color, float $balance)
    {
        $this->name = $name;
        $this->type = AccountType::Bank;
        $this->currency = $currency;
        $this->color = $color;
        $this->balance = $balance;

        $this->validate();

    }

    private function hash(): string
    {
        return md5("{$this->name}{$this->currency}{$this->color}{$this->balance}{$this->type->value}");
    }

    public function isEqualsTo(BankAccount $account): bool
    {
        return $this->hash() === $account->hash();
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
            'balance' =>  ['required','numeric'],
        ];

        Validator::validate($this->toArray(), $rules);
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->balance;
    }
}
<?php

namespace App\BudgetTracker\Entity\Accounts;

use App\BudgetTracker\Enums\AccountType;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\Rules\Account\AccountTypeValidation;
use App\Rules\Account\AccountColorValidation;
use App\Rules\Account\AccountCurrencyValidation;

use DateTime;

final class SavingAccount extends Account {

    public function __construct(string $name, string $currency, string $color, float $amout, float $balance, DateTime $date)
    {
        $this->name = $name;
        $this->type = AccountType::Saving;
        $this->currency = $currency;
        $this->color = $color;
        $this->amount = $amout;
        $this->date = $date->format('Y-m-d H:i:s');
        $this->balance = $balance;

        $this->validate();

    }

    private function hash(): string
    {
        return md5("{$this->name}{$this->currency}{$this->color}{$this->balance}{$this->type->value}{$this->date}");
    }

    public function isEqualsTo(SavingAccount $account): bool
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
            'installementValue' => ['required','numeric'],
            'date' => ['date', 'date_format:Y-m-d H:i:s', 'required'],
            'balance' =>  ['required','numeric'],
        ];

        Validator::validate($this->toArray(), $rules);
    }
}
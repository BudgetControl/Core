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

    /** @var AccountType */
    private $type;

    /** @var string */
    private $currency;

    /** @var string */
    private $color;

    /** @var string */
    private $name;

    /** @var bool */
    private $installement;

    /** @var float */
    private $installementValue;

    /** @var float */
    private $value;

    /** @var DateTime */
    private $date;

    public function __construct(string $name, string $currency, string $color, float $value, DateTime $date, bool $installement, float $installementValue = 0)
    {

        $this->name = $name;
        $this->type = AccountType::CreditCard;
        $this->currency = $currency;
        $this->value = $value;
        $this->color = $color;
        $this->installement = $installement;
        $this->installementValue = $installementValue;
        $this->date = $date->format('Y-m-d h:i:s');

        if($installement === true) {
            $this->installementValidate();
        }
        
        $this->validate();

    }

    /**
     * Get the value of date
     */ 
    public function getdate(): DateTime
    {
        return $this->date;
    }

    /**
     * Get the value of installementValue
     */ 
    public function getInstallementValue(): float
    {
        return $this->installementValue;
    }

    /**
     * Get the value of installement
     */ 
    public function getInstallement(): bool
    {
        return $this->installement;
    }


    /**
     * Get the value of color
     */ 
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }
    private function hash(): string
    {
        return md5("{$this->name}{$this->currency}{$this->color}{$this->value}{$this->type->value}{$this->installement}{$this->installementValue}{$this->date}");
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
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
            'value' =>  ['required','numeric'],
        ];

        Validator::validate($this->toArray(), $rules);
    }
}
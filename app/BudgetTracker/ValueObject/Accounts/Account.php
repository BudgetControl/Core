<?php

namespace App\BudgetTracker\ValueObject\Accounts;

use App\BudgetTracker\Enums\AccountType;
use App\BudgetTracker\Interfaces\AccountInterface;

abstract class Account implements AccountInterface
{

    /** @var AccountType */
    protected $type = AccountType::Bank;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $color;

    /** @var string */
    protected $name = '';

    /** @var float */
    protected $value = 0;

    /** @var float */
    protected $amount = 0;

    /** @var bool */
    protected $installement = false;

    /** @var float */
    protected $installementValue = 0;

    /** @var \DateTime|null */
    protected $date = null;

    public function toArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type->value,
            'color' => $this->color,
            'currency' => $this->currency,
            'installement' => $this->installement,
            'installementValue' => $this->installementValue,
            'date' => $this->date,
            'value' => $this->value,
            'amount' => $this->amount
        ];
    }
}

<?php

namespace App\BudgetTracker\Entity\Accounts;

use App\BudgetTracker\Enums\AccountType;
use App\BudgetTracker\Interfaces\AccountInterface;

class Account implements AccountInterface
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
    protected $balance = 0;

    /** @var float */
    protected $amount = 0;

    /** @var bool */
    protected $installement = false;

    /** @var float */
    protected $installementValue = 0;

    /** @var \DateTime|null */
    protected $date = null;

    /** @var bool */
    protected $excludeFromStats = false;

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
            'balance' => $this->balance,
            'exclude_from_stats' => $this->excludeFromStats
        ];
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of installementValue
     */ 
    public function getInstallementValue()
    {
        return $this->installementValue;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }


    /**
     * Get the value of balance
     */ 
    public function getBalance()
    {
        return round($this->balance,2);
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the value of currency
     */ 
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value of installement
     */ 
    public function getInstallement()
    {
        return $this->installement;
    }

    public function hash(): string{
        return "";
    }
    

    /**
     * Get the value of excludeFromStats
     */
    public function getExcludeFromStats()
    {
        return $this->excludeFromStats;
    }
}

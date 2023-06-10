<?php

namespace App\BudgetTracker\DataObjects;

use App\Helpers\MathHelper;

final class Wallet {

    /** @var float $balance  */
    private $balance;

    public function __construct(float $initialBalance = 0.0)
    {
        $this->balance = $initialBalance;
    }

    /**
     * Get the value of balance
     */ 
    public function getBalance(): float
    {
        return round($this->balance,2);
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */ 
    public function setBalance($balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function deposit(float $amount): self
    {
        $this->balance += $amount;

        return $this;
    }

    public function withdraw(float $amount): self
    {
        $this->balance -= $amount;

        return $this;
    }

    public function sum(array $entries): void
    {
      if(!empty($entries)) {
            $this->balance += MathHelper::sum($entries);
        }
    }
}
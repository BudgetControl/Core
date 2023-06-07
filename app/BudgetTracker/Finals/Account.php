<?php

namespace App\BudgetTracker\Finals;

use App\BudgetTracker\Enums\AccountType;

final class Account {

    /** @var AccountType */
    private $accountType;

    /** @var int */
    private $installement;

    public function __construct(AccountType $accountType, int $installement)
    {

        if (!in_array($accountType, $this->getAccountType())) {
            throw new \InvalidArgumentException("Account type should be a valid one: {$accountType->value}.");
        }

        if ($installement === true || $installement === false) {
            throw new \InvalidArgumentException("Account installement should be true or false.");
        }

        $this->accountType = $accountType;
        $this->installement = $installement;
    }

    private function getAccountType(): array
    {
        return (array) array_column(AccountType::cases(), 'name');
    }
}
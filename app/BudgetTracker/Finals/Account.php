<?php

namespace App\BudgetTracker\Finals;

use App\BudgetTracker\Enums\AccountType;
use App\BudgetTracker\Constants\Currency;
use DateTime;

final class Account {

    /** @var AccountType */
    private $accountType;

    /** @var int */
    private $installement;

    /** @var string */
    private $currency;

    /** @var float */
    private $installementValue;

    /** @var DateTime */
    private $date_end;

    public function __construct(AccountType $accountType, int $installement, string $currency, float $installementValue, DateTime $date_end)
    {

        if (!in_array($accountType, $this->getAccountType())) {
            throw new \InvalidArgumentException("Account type should be a valid one: {$accountType->value}.");
        }

        if ($installement !== true && $installement !== false) {
            throw new \InvalidArgumentException("Account installement should be true or false.");
        }

        if(empty($installementValue) && $installement === true) {
            throw new \InvalidArgumentException("Account installement value ust be a value.");
        }

        if(!array_key_exists($currency,Currency::data)) {
            throw new \InvalidArgumentException("Account currency must be valid.");
        }

        $this->accountType = $accountType;
        $this->installement = $installement;
        $this->currency = $currency;

    }

    private function getAccountType(): array
    {
        return (array) array_column(AccountType::cases(), 'name');
    }

    private function hasSameCurrency(Account $account): bool
    {
        return $this->currency === $account->currency;
    }

    private function hash(): string
    {
        return md5("{$this->accountType->value}{$this->currency}{$this->installement}");
    }

    public function isEqualsTo(Account $account): bool
    {
        return $this->hash() === $account->hash();
    }
}
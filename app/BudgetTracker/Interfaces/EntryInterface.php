<?php
namespace App\BudgetTracker\Interfaces;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Payee;
use DateTime;
use stdClass;

interface EntryInterface {

    public function __construct(
        float $amount,
        Currency $currency,
        string $note,
        SubCategory $category,
        Account $account,
        PaymentsTypes $paymentType,
        DateTime $date_time,
        array $labels = [],
        bool $confirmed = true,
        bool $waranty = false,
        object $geolocation = new stdClass(),
        bool $transfer = false,
        Payee $payee = null,
        EntryType $type = EntryType::Incoming,
    );

    /**
     * Return value of amount
     * @return float
     */
    public function getAmount(): float;

    /**
     * Return value of amount
     * @return EntryType
     */
    public function getType(): EntryType;

    /**
     * Return value of currency
     * @return Currency
     */
    public function getCurrency(): Currency;

    
    /**
     * Return value of dateTime
     * @return DateTime
     */
    public function getDateTime(): DateTime;

    /**
     * Get the value of planned
     */
    public function getPlanned(): bool;

    /**
     * Get the value of note
     */ 
    public function getNote(): string;

    /**
     * Get the value of waranty
     */ 
    public function getWaranty(): bool;
    /**
     * Get the value of transfer
     */ 
    public function getTransfer(): bool;

    /**
     * Get the value of confirmed
     */ 
    public function getConfirmed(): bool;

    /**
     * Get the value of category
     */ 
    public function getCategory(): SubCategory;

    /**
     * Get the value of account
     */ 
    public function getAccount(): Account;

    /**
     * Get the value of paymentType
     */ 
    public function getPaymentType(): PaymentsTypes;

    /**
     * Get the value of geolocation
     */ 
    public function getGeolocation(): stdClass;

    /**
     * 
     */
    public function toArray(): array;

    /**
     * unique hash
     */
    public function getHash(): string;


}
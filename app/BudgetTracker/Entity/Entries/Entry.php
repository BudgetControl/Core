<?php

namespace App\BudgetTracker\Entity\Entries;

use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Models\PaymentsTypes;
use DateTime;
use League\Config\Exception\ValidationException;
use Illuminate\Support\Facades\Validator;
use stdClass;

class Entry implements EntryInterface
{

    protected float $amount;
    protected Currency $currency;
    protected EntryType $type;
    protected string $note;
    protected DateTime $date_time;
    protected bool $waranty;
    protected bool $transfer;
    protected bool $confirmed;
    protected SubCategory $category;
    protected Account $account;
    protected PaymentsTypes $paymentType;
    protected object $geolocation;
    protected array $labels;
    protected Payee|null $payee = null;

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
        int $transfer_id = 0,
        object $geolocation = new stdClass(),
        bool $transfer = false,
        Payee|null $payee = null,
        EntryType $type = EntryType::Incoming,
    ) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->date_time = $date_time;
        $this->type = $type;
        $this->waranty = $waranty;
        $this->transfer = $transfer;
        $this->confirmed = $confirmed;
        $this->category = $category;
        $this->account = $account;
        $this->paymentType = $paymentType;
        $this->geolocation = $geolocation;
        $this->labels = $labels;
        $this->note = $note;
        $this->payee = $payee;

        $this->validate();
    }

    /**
     * validate informations
     * 
     * @return void
     * @throws ValidationException
     */
    private function validate(): void
    {
        $rules = [
            'date_time' => ['date', 'date_format:Y-m-d H:i:s', 'required'],
            'amount' => ['required', 'numeric'],
            'note' => 'nullable',
            'waranty' => 'boolean',
            'transfer' => 'boolean',
            'confirmed' => 'boolean',
            'planned' => 'boolean',
            'category_id' => ['required', 'integer'],
            'account_id' => ['required', 'integer'],
            'currency_id' => ['required', 'integer'],
            'payment_type' => ['required', 'integer'],
            'geolocation' => ['nullable']
        ];

        Validator::validate($this->toArray(), $rules);
    }

    /**
     *
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'date_time' => $this->date_time->format('Y-m-d H:i:s'),
            'amount' => $this->amount,
            'note' => $this->note,
            'waranty' => $this->waranty,
            'transfer' => $this->transfer,
            'confirmed' => $this->confirmed,
            'planned' => $this->isPlanned(),
            'category_id' => $this->category->id,
            'account_id' => $this->account->id,
            'currency_id' => $this->currency->id,
            'payment_type' => $this->paymentType->id,
            'geolocation' => $this->geolocation,
            'payee_id' => $this->payee,
            'label' => $this->labels
        ];
    }

    /** 
     * chek if is planned entry
     * 
     * @return bool
     */
    private function isPlanned(): bool
    {
        $today = new \DateTime();
        if ($this->date_time->getTimestamp() > $today->getTimestamp()) {
            return true;
        }

        return false;
    }

    private function hash(): string
    {
        return md5("{$this->amount}{$this->note}{$this->category->name}{$this->account->name}{$this->currency->name}{$this->type->value}");
    }

    public function isEqualsTo(Entry $entry): bool
    {
        return $this->hash() === $entry->hash();
    }

    public function getHash(): string
    {
        $time = time();
        return md5("{$this->amount}{$this->note}{$this->category->name}{$this->account->name}{$this->currency->name}{$this->paymentType->name}{$this->type->value}{$time}");
    }

    /**
     * Get the value of planned
     */
    public function getPlanned(): bool
    {
        return $this->isPlanned();
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * Get the value of currency
     */ 
    public function getCurrency(): Currency 
    {
        return $this->currency;
    }

    /**
     * Get the value of type
     */ 
    public function getType(): EntryType
    {
        return $this->type;
    }

    /**
     * Get the value of note
     */ 
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * Get the value of date_time
     */ 
    public function getDateTime(): DateTIme
    {
        return $this->date_time;
    }

    /**
     * Get the value of waranty
     */ 
    public function getWaranty(): bool
    {
        return $this->waranty;
    }

    /**
     * Get the value of transfer
     */ 
    public function getTransfer(): bool
    {
        return $this->transfer;
    }

    /**
     * Get the value of confirmed
     */ 
    public function getConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory(): SubCategory
    {
        return $this->category;
    }

    /**
     * Get the value of account
     */ 
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * Get the value of paymentType
     */ 
    public function getPaymentType(): PaymentsTypes
    {
        return $this->paymentType;
    }

    /**
     * Get the value of geolocation
     */ 
    public function getGeolocation(): stdClass
    {
        return $this->geolocation;
    }

    /**
     * Get the value of labels
     */ 
    public function getLabels(): array
    {
        return $this->labels;
    }

    /** format a date
     * 
     */
    public function getDateFormat(): string
    {
        return $this->date_time->format('Y-m-d H:i:s');
    }

    /**
     * Get the value of payee
     */ 
    public function getPayee(): Payee
    {
        return $this->payee;
    }
}

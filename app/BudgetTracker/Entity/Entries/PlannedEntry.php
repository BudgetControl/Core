<?php

namespace App\BudgetTracker\Entity\Entries;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use League\Config\Exception\ValidationException;
use Nette\Schema\ValidationException as NetteException;
use App\BudgetTracker\Models\Payee;
use stdClass;
use DateTime;

class PlannedEntry extends Entry {

    /** @var PlanningType */
    private $planning;
    /** @var DateTime */
    private $endDateTime;
    /**
     * Summary of __construct
     * @param float $amount
     * @param \App\BudgetTracker\Models\Currency $currency
     * @param string $note
     * @param \App\BudgetTracker\Models\SubCategory $category
     * @param \App\BudgetTracker\Models\Account $account
     * @param \App\BudgetTracker\Models\PaymentsTypes $paymentType
     * @param \DateTime $date_time
     * @param array $labels
     * @param bool $confirmed
     * @param bool $waranty
     * @param int $transfer_id
     * @param object $geolocation
     * @param bool $transfer
     * @param \App\BudgetTracker\Models\Payee|null $payee
     * @param \App\BudgetTracker\Enums\EntryType $type
     */
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

        parent::__construct($amount,$currency,$note,$category,$account,$paymentType,$date_time,$labels,$confirmed,$waranty,$transfer_id,$geolocation);

    }

    /**
     * Get the value of planning
     */ 
    public function getPlanning()
    {
        return $this->planning;
    }

    /**
     * Set the value of planning
     *
     * @return  self
     */ 
    public function setPlanning($planning)
    {
        if($planning === null) {
            throw new \Exception("Planned type not valid");
        }

        $this->planning = $planning;

        return $this;
    }

    /**
     * Get the value of endDateTime
     */ 
    public function getEndDateTime()
    {
        return $this->endDateTime->format("Y-m-d H:i:s");
    }

    /**
     * Set the value of endDateTime
     *
     * @return  self
     */ 
    public function setEndDateTime($endDateTime)
    {
        $this->endDateTime = $endDateTime;

        return $this;
    }

    public function toArray(): array
    {
        if($this->endDateTime === null) {
            $endDateTime = null;
        } else {
            $endDateTime = $this->endDateTime->format('Y-m-d H:i:s');
        }

        return [
            'type' => $this->type->value,
            'date_time' => $this->date_time->format('Y-m-d H:i:s'),
            'amount' => $this->amount,
            'note' => $this->note,
            'waranty' => $this->waranty,
            'transfer' => $this->transfer,
            'confirmed' => $this->confirmed,
            'category_id' => $this->category->id,
            'account_id' => $this->account->id,
            'currency_id' => $this->currency->id,
            'payment_type' => $this->paymentType->id,
            'geolocation' => $this->geolocation,
            'payee_id' => $this->payee,
            'label' => $this->labels,
            'planning' => $this->planning,
            'end_date_time' => $endDateTime,
        ];
    }

    public function get(): array
    {
        if($this->endDateTime === null) {
            $endDateTime = null;
        } else {
            $endDateTime = $this->endDateTime->format('Y-m-d H:i:s');
        }

        return [
            'type' => $this->type->value,
            'date_time' => $this->date_time->format('Y-m-d H:i:s'),
            'amount' => $this->amount,
            'note' => $this->note,
            'waranty' => $this->waranty,
            'transfer' => $this->transfer,
            'confirmed' => $this->confirmed,
            'category' => $this->category,
            'account' => $this->account,
            'currency' => $this->currency,
            'payment_type' => $this->paymentType,
            'geolocation' => $this->geolocation,
            'payee' => $this->payee,
            'label' => $this->labels,
            'planning' => $this->planning,
            'end_date_time' => $endDateTime,
        ];
    }
}
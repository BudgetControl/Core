<?php

namespace App\BudgetTracker\Entity\Entries;


use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Entity\Entries\Entry;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use League\Config\Exception\ValidationException;
use Nette\Schema\ValidationException as NetteException;
use DateTime; use stdClass;

class Transfer extends Entry {

    private int $transfer_id;
    private string $transfer_relation;

    public function __construct(
        float $amount,
        Currency $currency,
        string $note,
        DateTime $date_time,
        bool $waranty,
        bool $confirmed,
        Account $account,
        PaymentsTypes $paymentType,
        object $geolocation,
        array $labels,
        int $transfer_id,
    ) {
        parent::__construct($amount,EntryType::Transfer,$currency,$note,$date_time,$waranty,true,$confirmed,SubCategory::findOrFail(75),$account,$paymentType,$geolocation,$labels);
        $this->transfer_id = $transfer_id;
    }


    public function setAccount(Account $account)
    {
        $this->account = $account;
    }
    

    /**
     * Get the value of transfer_id
     */ 
    public function getTransfer_id()
    {
        return $this->transfer_id;
    }

    /**
     * Get the value of transfer_relation
     */ 
    public function getTransfer_relation()
    {
        return $this->transfer_relation;
    }

    /**
     * Set the value of transfer_relation
     *
     * @return  self
     */ 
    public function setTransfer_relation($transfer_relation)
    {
        $this->transfer_relation = $transfer_relation;

        return $this;
    }

}
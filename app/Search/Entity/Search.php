<?php

namespace Search\Entity;

use App\Helpers\MathHelper;
use Illuminate\Database\Eloquent\Model;
use \stdClass;

final class Search {

    /** @var array */
    private $entry;
    /** @var float */
    private $balance;

    public function __construct()
    {
        $this->entry = [];
    }

    /**
     * Get the value of entry
     */ 
    public function getEntry(): array
    {
        return $this->entry;
    }

    /**
     * Set the value of entry
     *
     * @return  self
     */ 
    public function setEntry(\App\BudgetTracker\Models\Entry $entry): self
    {
        $this->entry[] = $entry->toArray();

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getBalance(): float
    {
        $amount = sum($this->entry);
        return $amount;
    }

}
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
    public function setEntry(stdClass $entry): self
    {
        $this->entry[] = $entry;

        return $this;
    }

    /**
     * Get the value of amount
     */ 
    public function getBalance(): float
    {
        $amount = MathHelper::sum($this->entry);
        return $amount;
    }

}
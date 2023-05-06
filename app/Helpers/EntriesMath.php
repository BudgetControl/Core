<?php
namespace App\Helpers;

use App\BudgetTracker\Exceptions\EntryException;
use App\Helpers\MathHelper;

class EntriesMath {

    /** @var \App\BudgetTracker\Models\Entry|array|\Illuminate\Database\Eloquent\Collection $data */
    private \App\BudgetTracker\Models\Entry|array|\Illuminate\Database\Eloquent\Collection $data;

    
    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     * @param \App\BudgetTracker\Models\Entry|array|\Illuminate\Database\Eloquent\Collection $data
     * @return  self
     */ 
    public function setData(\App\BudgetTracker\Models\Entry|array|\Illuminate\Database\Eloquent\Collection $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * calculate the total type
     * @return int
     * 
     * @throws EntryException
     */
    public function sum(): int
    {
        if(empty($this->getData())) {
            throw new EntryException("No data foud to math in getTotal function");
        }

        return MathHelper::sum($this->getData());

    }
}
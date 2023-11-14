<?php
namespace App\BudgetTracker\Entity;

interface BudgetTracker {

    public function validate(): void;

    /**
     * Get the collection of items as a plain array.
     *
     * @return array<TKey, mixed>
     */
    public function toArray();

    /**
     * Get the collection of items as JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0);

}
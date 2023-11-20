<?php

namespace App\BudgetTracker\Services;

use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Interfaces\EntryInterface;
use Illuminate\Database\Eloquent\Model;

class WalletService
{

    private EntryInterface $entry;

    public function __construct(Model $entry)
    {
        $this->entry = $entry;
    }

    /**
     * update balance
     * @param EntryInterface $entry
     * 
     * @return void
     */
    public function sum(): void
    {
        $entry = $this->entry;
        
        $amount = $entry->amount;
        $isPlanned = $entry->planned;
        $isConfirmed = $entry->confirmed;
        $account = $entry->account_id;

        //update balance
        if ($isPlanned == false && $isConfirmed == true) {
            AccountsService::updateBalance($amount, $account);
            Log::debug("Update balance " . $amount . " , " . $account);
        }
    }

    /**
     * update balance
     * @param EntryInterface $entry
     * 
     * @return void
     */
    public function subtract(): void
    {
        $entry = $this->entry;
        
        $amount = $entry->amount;
        $isPlanned = $entry->planned;
        $isConfirmed = $entry->confirmed;
        $account = $entry->account_id;

        //update balance
        $amount = $amount * -1;
        if ($isPlanned == false && $isConfirmed == true) {
            AccountsService::updateBalance($amount, $account);
            Log::debug("subtract balance " . $amount . " , " . $account);
        }
    }
}

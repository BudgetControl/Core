<?php

namespace App\BudgetTracker\Services;

use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Entry as ModelsEntry;

class WalletService
{

    protected EntryInterface $entry;
    protected ?ModelsEntry $oldEntry = null;
    protected bool $revert = false;

    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
        $entryDB = ModelsEntry::where('id', $entry->getId())->first();
        if (!is_null($entryDB)) {
            $this->oldEntry = $entryDB;
        }
    }

    /**
     * update balance
     * 
     * @return void
     */
    public function sum(): void
    {
        //first check if is confirmed
        if ($this->checkConfirmed() === true) {
            // now check if is planned
            if ($this->checkPlanned() === false) {
                $entry = $this->entry;

                $amount = $entry->getAmount();
                $account = $entry->getAccount()->id;

                //update balance
                $this->update($amount, $account);
                Log::debug("Update balance " . $amount . " , " . $account);
            }
        }
        $this->revert();
    }

    /**
     * update balance
     * 
     * @return void
     */
    public function subtract(): void
    {
        //first check if is confirmed
        if ($this->checkConfirmed() === true) {
            // now check if is planned
            if ($this->checkPlanned() === false) {
                $entry = $this->entry;

                $amount = $entry->getAmount();
                $account = $entry->getAccount()->id;

                //update balance
                $amount = $amount * -1;
                $this->update($amount, $account);
                Log::debug("subtract balance " . $amount . " , " . $account);
            }
        }

    }

    /**
     * chek if entry is planned type
     */
    protected function checkPlanned(): bool
    {
        // check only new entry
        if (is_null($this->oldEntry)) {
            return $this->entry->getPlanned();
        }

        if ($this->oldEntry->planned == false) {
            $this->revert = true;
        }

        return $this->entry->getPlanned();
    }

    /**
     * chek if entry is confirmet type
     */
    protected function checkConfirmed(): bool
    {
        // check only new entry
        if (is_null($this->oldEntry)) {
            return $this->entry->getConfirmed();
        }

        if ($this->oldEntry->confirmed == true) {
            $this->revert = true;
        }

        return $this->entry->getConfirmed();
    }

    /**
     * is account changed
     */
    protected function isAccountChanged()
    {

        if (!is_null($this->oldEntry)) {
            $previusAccount = $this->oldEntry->account_id;
            $account = $this->entry->getAccount()->id;

            if($this->oldEntry->confirmed == true) {
                if($this->oldEntry->planned == false) {
                    if ($previusAccount != $account) {
                        $this->update(
                            $this->oldEntry->amount * -1,
                            $previusAccount
                        );
                        $this->revert = false;
                    }
                }
            }

            
        }
    }

    /**
     * revert to wallet
     */
    protected function revert()
    {
        $this->isAccountChanged();
        if ($this->revert === true) {
            AccountsService::updateBalance($this->oldEntry->amount * -1, $this->oldEntry->account_id);
        }
    }

    /**
     * 
     */
    protected function update(float $amount, int $account)
    {
        AccountsService::updateBalance($amount, $account);
    }
}

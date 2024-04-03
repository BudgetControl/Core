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
        if ($this->entry->getConfirmed() === true) {
            Log::debug($this->entry->getId() . " - is confirmed");
            // now check if is planned
            if ($this->entry->getPlanned() === false) {
                Log::debug($this->entry->getId() . " - is planned");
                $entry = $this->entry;

                $amount = $entry->getAmount();
                $account = $entry->getAccount()->id;

                //update balance
                Log::debug($this->entry->getId() . " - update with " . $amount . " on $account");
                $this->update($amount, $account);
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

        if ($this->entry->getConfirmed() === true) {
            Log::debug($this->entry->getId() . " - is confirmed");
            // now check if is planned
            if ($this->entry->getPlanned() === false) {
                Log::debug($this->entry->getId() . " - is planned");
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
        if (!is_null($this->oldEntry)) {
            if ($this->oldEntry->planned == false && $this->entry->getPlanned() == true) {
                Log::debug($this->entry->getId() . " old entry was planned REVERT");
                return true;
            }
        }

        return false;
    }

    /**
     * chek if entry is confirmet type
     */
    protected function checkConfirmed(): bool
    {
        if (!is_null($this->oldEntry)) {
            if ($this->oldEntry->confirmed == true && $this->entry->getConfirmed() == false) {
                Log::debug($this->entry->getId() . " old entry was not confirmed REVERT");
                return true;
            }
        }

        return false;
    }

    /**
     * chek if entry is confirmet type
     */
    protected function checkAmount(): bool
    {
        if (!is_null($this->oldEntry)) {
            if ($this->oldEntry->amount != $this->entry->getAmount() &&  ($this->oldEntry->confirmed == true && $this->oldEntry->planned == false)) {
                Log::debug($this->entry->getId() . " old entry has different amount REVERT");
                return true;
            }
        }

        return false;
    }

    /**
     * is account changed
     */
    protected function checkAccount()
    {
        if (!is_null($this->oldEntry)) {
            if ($this->oldEntry->account != $this->entry->getAccount() && ($this->oldEntry->confirmed == true && $this->oldEntry->planned == false)) {
                Log::debug($this->entry->getId() . " old entry has different account REVERT");
                return true;
            }
        }

        return false;
    }

    /**
     * is to revert
     */
    protected function isRevert(): bool
    {
        if ($this->checkConfirmed() || $this->checkPlanned() || $this->checkAccount() || $this->checkAmount()) { //
            return true;
        }

        return false;
    }

    /**
     * revert to wallet
     */
    protected function revert()
    {
        $revert = $this->isRevert();

        if ($revert === true) {
            Log::debug($this->entry->getId() . " REVERTING");
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

<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Entity\Entries\Entry as EntriesEntry;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Entity\Entries\Entry;
use App\BudgetTracker\Models\Entry as Model;

class WalletService
{

    private EntryInterface $entry;
    private ?EntryInterface $oldEntry = null;
    private bool $revert = false;

    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
        $entryDB = Model::where('uuid', $entry->getUuid())->first();
        if (!is_null($entryDB)) {
            $this->oldEntry = EntryService::create($entryDB->toArray(), EntryType::from($entryDB->type));
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

        $this->revert();
    }

    /**
     * chek if entry is planned type
     */
    private function checkPlanned(): bool
    {
        // check only new entry
        if (is_null($this->oldEntry)) {
            return $this->entry->getPlanned();
        }

        if ($this->oldEntry->getPlanned() === false) {
            $this->revert = true;
        }

        return $this->entry->getPlanned();
    }

    /**
     * chek if entry is confirmet type
     */
    private function checkConfirmed(): bool
    {
        // check only new entry
        if (is_null($this->oldEntry)) {
            return $this->entry->getConfirmed();
        }

        if ($this->oldEntry->getConfirmed() === true) {
            $this->revert = true;
        }

        return $this->entry->getConfirmed();
    }

    /**
     * is account changed
     */
    private function isAccountChanged()
    {

        if (!is_null($this->oldEntry)) {
            $previusAccount = $this->oldEntry->getAccount()->id;
            $account = $this->entry->getAccount()->id;

            if($this->oldEntry->getConfirmed() === true) {
                if($this->oldEntry->getPlanned() === false) {
                    if ($previusAccount != $account) {
                        $this->update(
                            $this->oldEntry->getAmount() * -1,
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
    private function revert()
    {
        $this->isAccountChanged();
        if ($this->revert === true) {
            AccountsService::updateBalance($this->oldEntry->getAmount() * -1, $this->oldEntry->getAccount()->id);
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

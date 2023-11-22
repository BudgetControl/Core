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
    private ?EntryInterface $oldEntry;

    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
        $entryDB = Model::where('uuid', $entry->getUuid())->first();
        $this->oldEntry = EntryService::create($entryDB, EntryType::from($entryDB->type));

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
            if ($this->checkPlanned() === true) {
                $entry = $this->entry;

                $amount = $entry->getAmount();
                $account = $entry->getAccount()->id;

                //update balance
                AccountsService::updateBalance($amount, $account);
                Log::debug("Update balance " . $amount . " , " . $account);
            }
        }
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
            $entry = $this->entry;

            $amount = $entry->getAmount();
            $account = $entry->getAccount()->id;

            //update balance
            $amount = $amount * -1;
            AccountsService::updateBalance($amount, $account);
            Log::debug("subtract balance " . $amount . " , " . $account);
        }
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
            AccountsService::updateBalance($this->oldEntry->getAmount() * -1, $this->oldEntry->getAccount()->id);
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
            AccountsService::updateBalance($this->oldEntry->getAmount() * -1, $this->oldEntry->getAccount()->id);
        }

        return $this->entry->getConfirmed();
    }
}

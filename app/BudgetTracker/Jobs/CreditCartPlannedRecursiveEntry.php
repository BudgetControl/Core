<?php

namespace App\BudgetTracker\Jobs;

use App\BudgetTracker\Entity\Entries\Entry as EntriesEntry;
use App\BudgetTracker\Entity\Entries\Transfer;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\Services\ExpensesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Services\EntryService;
use App\BudgetTracker\Services\TransferService;
use Illuminate\Support\Facades\Log;
use stdClass;

class CreditCartPlannedRecursiveEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Find credit card entry to insert");
        try {

            $accounts = $this->findCreditCards();
            foreach($accounts as $account) {
                Log::debug("Found account ".$account->id);
                $entry = $this->entry($account->installementValue,$account);

                if($this->exist($entry->getNote()) === false) {
                    $service = new TransferService();
                    $entryArray = $entry->toArray();
                    $entryArray['user_id'] = $account->user_id;
                    //TODO: fixme these must be configurable
                    $entryArray['transfer_id'] = 41;

                    $service->save($entryArray);
                }
            }

        } catch (\Exception $e) {
            Log::error('Error while insert new credit card recursive entry '.$e->getMessage());
        }
    }

    /**
     * find planned entries
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function findCreditCards() : \Illuminate\Database\Eloquent\Collection
    {   
        return Account::where('installement',1)->get();
    }

    private function entry(float $amount,Account $account): EntriesEntry
    {
        $date = new \DateTime($account->date);
        $day = $date->format('d');
        $newDate = date('Y',time()).'-'.date('m',time()).'-'.$day;

        return new Transfer(
            $amount,
            Currency::find(11),
            $account->name . ' '. $newDate,
            new \DateTime($newDate),
            false,
            true,
            $account,
            PaymentsTypes::find(1),
            new stdClass(),
            [],
            0
        );
    }

    private function exist($note): bool
    {
        $entry = Entry::where('note', $note)->get();
        if($entry->count() == 0) {
            Log::debug("No entry found with ".$note);
            return false;
        }
        Log::debug("Founded entry ".$note);
        return true;
    }
}

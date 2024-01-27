<?php

namespace App\BudgetTracker\Jobs;

use Illuminate\Bus\Queueable;
use App\BudgetTracker\Models\Entry;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\BudgetTracker\Services\EntryService;
use App\BudgetTracker\Services\WalletService;

class ActivatePlannedEntries extends BudgetControlJobs implements ShouldQueue
{

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
    public function job(): void
    {
        Log::info("Start activate planned JOB");

        $plannedEntry = $this->findPlannedEntries();

        if ($plannedEntry->count() != 0) {
            foreach ($this->findPlannedEntries() as $entry) {

                $entry->update([
                    'planned' => 0,
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ]);

                $walletService = new WalletService(
                    EntryService::create($entry->toArray(), $entry->getType())
                );
                $walletService->sum();

                Log::info("Activated entry: " . json_encode($entry->toArray()));
            }
        } else {
            Log::debug("No entry to activate found");
        }
    }

    /**
     * find planned entries
     * @return \Illuminate\Database\Eloquent\Collection 
     */
    private function findPlannedEntries(): \Illuminate\Database\Eloquent\Collection
    {
        return Entry::where('planned', 1)->where('date_time', '<=', date('Y-m-d H:i:s', time()))->get();
    }
}

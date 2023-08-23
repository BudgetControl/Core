<?php

namespace App\BudgetTracker\Jobs;

use App\BudgetTracker\Enums\EntryType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\BudgetTracker\Models\Entry;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Services\EntryService;

class ActivatePlannedEntries implements ShouldQueue
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
        Log::info("Start activate planned JOB");

        $plannedEntry = $this->findPlannedEntries();

        if($plannedEntry->count() != 0) {
            foreach($this->findPlannedEntries() as $entry) {

                $data = $entry->toArray();
                $data['planned'] = 0;
                $data['updated_at'] = date('Y-m-d H:i:s', time());
                $data['label'] = [];
    
                $service = new EntryService($data['uuid']);
                $service->save($data,EntryType::from($data['type']));
    
                Log::info("Activated entry: ".json_encode($entry->toArray()));
            }
        } else {
            Log::debug("No entry to activate found");
        }
    }

    /**
     * find planned entries
     * @return \Illuminate\Database\Eloquent\Collection 
     */
    private function findPlannedEntries() : \Illuminate\Database\Eloquent\Collection
    {   
        return Entry::where('planned',1)->where('date_time', '<=', date('Y-m-d H:i:s',time()))->get();
    }
}

<?php

namespace App\BudgetTracker\Jobs;

use App\BudgetTracker\Services\EntryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\BudgetTracker\Models\PlannedEntries;
use Exception;
use Illuminate\Support\Facades\Log;

class InsertPlannedEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info("Start planned entry JOB");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        Log::info("Check for planned entries");
        $this->insertEntry($this->getPlannedEntry());
    }

    /**
     * get planned entry from date
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPlannedEntry()
    {
        $date = date("Y-m-d H:i:s",time());
        $newDate = strtotime($date . "+1 month");

        $entry = PlannedEntries::where("date_time", "<=", date('Y-m-d',$newDate))->get();
        Log::info("Found " . $entry->count() . " of new entry to insert");
        return $entry;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $data
     * @return void
     */
    private function insertEntry(\Illuminate\Database\Eloquent\Collection $data)
    {
        try {
            foreach ($data as $request) {
                $entryService = new EntryService();

                $paymentType = $request->payment_type;
                $account = $request->account_id;
                $currency = $request->currency_id;
                $category = $request->category_id;

                $entry = new \stdClass();

                $entry->amount = $request->amount;
                $entry->note = $request->note;
                $entry->type = $request->type;
                $entry->category_id = $category;
                $entry->payment_type = $paymentType;
                $entry->account_id = $account;
                $entry->currency_id = $currency;
                $entry->planned = 1;
                $entry->date_time = $request->date_time->format('Y-m-d H:i:s');
                $entry->label = []; //FIXME:: $request->label;

                $entryService->save((array) $entry);
                Log::info("PLANNED INSERT:: " . json_encode($entry));

            }

            $this->updatePlanningEntry($data);

        } catch (Exception $e) {
            Log::critical("Unable to insert new planned entry " . $e);
        }
    }

    /**
     * update planning entry to next data
     * @param \Illuminate\Database\Eloquent\Collection $data
     * @return void
     */
    private function updatePlanningEntry(\Illuminate\Database\Eloquent\Collection $data) {
        foreach($data as $e) {
            switch($e->planning) {
                case "daily":
                    $increment = "+1 Day";
                    break;
                    case "monthly":
                    $increment = "+1 Month";
                    break;
                    case "yearly":
                    $increment = "+1 Year";
                    break;
                    default:
                    $increment = "+0 Day";
                    break;
            }

            $date = $e->date_time->modify($increment);
            Log::info("Changed planned date ID: ".$e->id. " ".$e->date_time->format('Y-m-d H:i:s')." --> ".$date);
            $e->updated_at = date("Y/m/d H:i:s",time());
            $e->date_time = $date->format('Y-m-d H:i:s');
            $e->save();
        }
    }
}

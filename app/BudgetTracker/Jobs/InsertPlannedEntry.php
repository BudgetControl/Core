<?php

namespace App\BudgetTracker\Jobs;

use App\BudgetTracker\Models\Entry as EntryModel;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Services\EntryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\BudgetTracker\Models\PlannedEntries;

use Exception;
use Illuminate\Support\Facades\Log;
use stdClass;

class InsertPlannedEntry extends BudgetControlJobs implements ShouldQueue
{

    const TIME = [
        'daily', 'weekly', 'monthly', 'yearly'
    ];

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
    public function job(): void
    {
        Log::info("Check for planned entries");
        foreach (self::TIME as $time) {
            $this->insertEntry($this->getPlannedEntry($time));
        }
    }

    /**
     * get planned entry from date
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPlannedEntry(string $time)
    {
        $newDate = $this->getTimeValue($time);
        $newDate = date('Y-m-d H:i:s', $newDate);
        $toDay = date('Y-m-d H:i:s', time()) ;

        $entry = PlannedEntries::where("date_time", "<=", $newDate)
            ->where("deleted_at", null)
            ->where("planning", $time)
            ->where("end_date_time", ">=", $toDay)
            ->orWhere("end_date_time", null)->get();
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

            /** @var EntryModel $request  */
            foreach ($data as $request) {

                $entry = $request->toArray();
                $entryToInsert = new EntryModel(['user_id' => $entry['user_id']]);
                $entryToInsert->transfer = 0;
                $entryToInsert->amount = $entry['amount'];
                $entryToInsert->account_id = $entry['account_id'];
                $entryToInsert->category_id = $entry['category_id'];
                $entryToInsert->type = $entry['type'];
                $entryToInsert->waranty = 0;
                $entryToInsert->confirmed = 1;
                $entryToInsert->planned = 1;
                $entryToInsert->date_time = $entry['date_time'];
                $entryToInsert->note = $entry['note'];
                $entryToInsert->currency_id = $entry['currency_id'];
                $entryToInsert->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();

                $entryToInsert->save();

                Log::info("PLANNED INSERT:: " . json_encode($entryToInsert));
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
    private function updatePlanningEntry(\Illuminate\Database\Eloquent\Collection $data)
    {
        foreach ($data as $e) {
            switch ($e->planning) {
                case "daily":
                    $increment = "+1 Day";
                    break;
                case "monthly":
                    $increment = "+1 Month";
                    break;
                case "weekly":
                    $increment = "+7 Day";
                    break;
                case "yearly":
                    $increment = "+1 Year";
                    break;
                default:
                    $increment = "+0 Day";
                    break;
            }

            $date = $e->date_time->modify($increment);
            Log::info("Changed planned date ID: " . $e->id . " " . $e->date_time->format('Y-m-d H:i:s') . " --> " . $date);
            $e->updated_at = date("Y/m/d H:i:s", time());
            $e->date_time = $date->format('Y-m-d H:i:s');
            $e->save();
        }
    }

    /**
     *  get time to check
     */
    private function getTimeValue(string $timing): int
    {
        $date = date("Y-m-d H:i:s", time());

        switch ($timing) {
            case "daily":
                $newDate = strtotime($date . "+1 day");
                break;
            case "monthly":
                $newDate = strtotime($date . "+1 month");
                break;
            case "weekly":
                $newDate = strtotime($date . "+7 day");
                break;
            case "yearly":
                $newDate = strtotime($date . "+1 year");
                break;
            default:
                $newDate = strtotime($date);
                break;
        }

        return $newDate;
    }
}


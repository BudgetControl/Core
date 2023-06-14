<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\PlannedEntries;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Models\Payee;
use App\Http\Services\UserService;

/**
 * Summary of SaveEntryService
 */
class PlanningRecursivelyService extends EntryService
{

  /**
   * save a resource
   * @param array $data
   * @param EntryType|null $type
   * @param Payee|null $payee
   * 
   * @return void
   */
  public function save(array $data, EntryType|null $type = null, Payee|null $payee = null): void
    {
        try {

            Log::debug("save planning recursively -- " . json_encode($data));

            self::validate($data);

            if ($data['amount'] < 0) {
                $type = EntryType::Expenses->value;
            } else {
                $type = EntryType::Incoming->value;
            }

            $entry = new PlannedEntries(['type' => $type, 'planning' => PlanningType::from($data['planning'])]);
            if (!empty($data['id'])) {
                $entry = PlannedEntries::find($data['id']);
            }

            $entry->account_id = $data['account_id'];
            $entry->amount = $data['amount'];
            $entry->category_id = $data['category_id'];
            $entry->currency_id = $data['currency_id'];
            $entry->date_time = $data['date_time'];
            $entry->note = $data['note'];
            $entry->payment_type = $data['payment_type'];
            $entry->user_id = UserService::getCacheUserID();

            $entry->save();

            $this->attachLabels($data['label'], $entry);
            
        } catch (\Exception $e) {
            $error = uniqid();
            Log::error("$error " . $e->getMessage());
            throw new \Exception("Ops an errro occurred ".$error);
        }
    }

    /**
     * read a resource
     * @param int $id of resource
     * 
     * @return object with a resource
     * @throws \Exception
     */
    static public function read(int $id = null): object
    {
        Log::debug("read planning recursively  -- $id");
        $result = new \stdClass();

        $entry = PlannedEntries::withRelations()->where('type', EntryType::Incoming->value);

        if ($id === null) {
            $entry = PlannedEntries::get();
        } else {
            $entry = PlannedEntries::find($id);
        }

        if (!empty($entry)) {
            Log::debug("found planning recursively -- " . $entry->toJson());
            $result = $entry;
        }

        return $result;
    }

    /**
     * read a resource
     *
     * @param array $data
     * @return void
     * @throws ValidationException
     */
    public static function validate(array $data): void
    {
        $rules = [
            'id' => ['integer'],
            'date_time' => ['date', 'date_format:Y-m-d H:i:s'],
            'account_id' => 'required|boolean',
            'name' => 'string'
        ];

        Validator::validate($data, $rules);
    }
}

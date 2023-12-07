<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\PlannedEntries;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Models\Payee;
use App\User\Services\UserService;
use App\BudgetTracker\Entity\Entries\PlannedEntry;
use DateTime;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use Exception;
use App\BudgetTracker\Exceptions\EntryException;

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

            //self::validate($data); FIXME: 

            $entry = new PlannedEntries(['type' => $type, 'planning' => PlanningType::from($data['planning'])]);
            if (!empty($data['uuid'])) {
                $entry = PlannedEntries::where('uuid', $data['uuid'])->first();
            }

            $entryData = $this->makeObj($data);

            $entryData = $entryData->toArray();
            $entry->uuid = $entryData['uuid'];
            $entry->account_id = $entryData['account_id'];
            $entry->amount = $entryData['amount'];
            $entry->category_id = $entryData['category_id'];
            $entry->currency_id = $entryData['currency_id'];
            $entry->date_time = $entryData['date_time'];
            $entry->note = $entryData['note'];
            $entry->payment_type = $entryData['payment_type'];
            $entry->planning = $entryData['planning'];
            $entry->type = $entryData['type'];
            $entry->end_date_time = ($entryData['end_date_time'] == $entryData['date_time']) ? null : $entryData['end_date_time'];
            $entry->user_id = empty($entryData['user_id']) ? UserService::getCacheUserID() : $entryData['user_id'];

            $entry->save();

            $this->attachLabels($data['label'], $entry);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new EntryException("Ops an errro occurred ", 500);
        }
    }

    /**
     * read a resource
     * @param int $id of resource
     * 
     * @return object with a resource
     * @throws \Exception
     */
    public function read(string|null $id = null): object
    {
        Log::debug("read planning recursively  -- $id");

        $entries = PlannedEntries::withRelations()->where("deleted_at", null);

        if ($id !== null) {
            $entries->where('uuid', $id);
        }

        $resourses = [];

        $resources = $entries->get();

        $result = new \stdClass();
        $result->data = $resourses;

        if (count($result->data) === 1) {
            $result->data = $result->data[0];
        }

        return $resources;
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
            'date_time' => ['date', 'date_format:Y-m-d H:i:s'],
            'account_id' => 'required|integer',
            'name' => 'string'
        ];

        Validator::validate($data, $rules);
    }

    protected function makeObj(array $data): PlannedEntry
    {
        $endDateTime = new DateTime($data['end_date_time']);
        $planning = PlanningType::from($data['planning']);
        $label = empty($data['label']) ? [] : $data['label'];

        if ($data['amount'] < 0) {
            $type = EntryType::Expenses;
        } else {
            $type = EntryType::Incoming;
        }

        $plannedEntry = new PlannedEntry(
            $data['amount'],
            $type,
            Currency::findOrFail($data['currency_id']),
            $data['note'],
            new DateTime($data['date_time']),
            $endDateTime,
            $data['waranty'],
            false,
            $data['confirmed'],
            SubCategory::with('category')->findOrFail($data['category_id']),
            Account::findOrFail($data['account_id']),
            PaymentsTypes::findOrFail($data['payment_type']),
            new \stdClass(),
            $label,
            $planning
        );

        if (!empty($data['uuid'])) {
            $plannedEntry->setUuid($data['uuid']);
        }

        return $plannedEntry;
    }
}

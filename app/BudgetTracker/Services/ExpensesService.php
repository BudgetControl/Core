<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Expenses;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\Rules\AmountMinor;

/**
 * Summary of SaveEntryService
 */
class ExpensesService extends EntryService implements EntryInterface
{
    function __construct()
    {
      $this->data = Expenses::withRelations()->orderBy('date_time','desc')->where('type',EntryType::Expenses->value);
    }

    /**
     * save a resource
     * @param array $data
     * 
     * @return void
     */
    public function save(array $data): void
    {
        try {

            Log::debug("save expenses -- " . json_encode($data));

            self::validate($data);
            $entry = new Expenses();
            if (!empty($data['uuid'])) {
                $entry = Expenses::findFromUuid($data['uuid']);
            }

            $entry->account_id = $data['account_id'];
            $entry->amount = $data['amount'];
            $entry->category_id = $data['category_id'];
            $entry->currency_id = $data['currency_id'];
            $entry->date_time = $data['date_time'];
            $entry->note = $data['note'];
            $entry->payment_type = $data['payment_type'];

            $entry->planned = $this->isPlanning(new \DateTime($entry->date_time));

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
    public static function read(int $id = null): object
    {
        Log::debug("read expenses -- $id");
        $result = new \stdClass();

        $entry = Expenses::withRelations()->where('type', EntryType::Expenses->value);

        if ($id === null) {
            $entry = $entry->get();
        } else {
            $entry = $entry->find($id);
        }

        if (!empty($entry)) {
            Log::debug("found expenses -- " . $entry->toJson());
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
            'date_time' => ['date', 'date_format:Y-m-d H:i:s','required'],
            'amount' => ['required', 'numeric', new AmountMinor()],
            'note' => 'nullable',
            'waranty' => 'boolean',
            'transfer' => 'boolean',
            'confirmed' => 'boolean',
            'planned' => 'boolean',
            'category_id' => ['required', 'integer'],
            'account_id' => ['required', 'integer'],
            'currency_id' => 'required|boolean',
            'payment_type' => ['required','integer'],
            'geolocation_id' => 'integer'
        ];

        Validator::validate($data, $rules);
    }
}

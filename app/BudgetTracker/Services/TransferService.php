<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Transfer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;

/**
 * Summary of SaveEntryService
 */
class TransferService extends EntryService implements EntryInterface
{

    function __construct()
    {
      $this->data = Transfer::withRelations()->orderBy('date_time','desc')->where('type',EntryType::Transfer->value);
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

            Log::debug("save transfer -- " . json_encode($data));

            self::validate($data);

            $entry = new Transfer();
            if (!empty($data['uuid'])) {
                $entry = Transfer::findFromUuid($data['uuid']);
            }

            $entry->account_id = $data['account_id'];
            $entry->amount = $data['amount'];
            $entry->currency_id = $data['currency_id'];
            $entry->date_time = $data['date_time'];
            $entry->note = $data['note'];
            $entry->payment_type = $data['payment_type'];
            $entry->transfer_id = $data['transfer_id'];

            $entry->save();
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
        Log::debug("read entry -- $id");
        $result = new \stdClass();

        $entry = Transfer::withRelations()->where('type', EntryType::Transfer->value);

        if ($id === null) {
            $entry = $entry->get();
        } else {
            $entry = $entry->find($id);
        }

        if (!empty($entry)) {
            Log::debug("found transfer -- " . $entry->toJson());
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
            'amount' => ['required', 'numeric'],
            'note' => 'nullable',
            'waranty' => 'boolean',
            'transfer' => 'boolean',
            'confirmed' => 'boolean',
            'transfer_id' => ['required', 'integer'],
            'planned' => 'boolean',
            'account_id' => ['required', 'integer'],
            'currency_id' => 'required|boolean',
            'payment_type' => ['required','integer'],
            'geolocation_id' => 'integer'
        ];

        Validator::validate($data, $rules);
    }
}

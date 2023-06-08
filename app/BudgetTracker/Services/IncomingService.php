<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Incoming;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;

/**
 * Summary of SaveEntryService
 */
class IncomingService extends EntryService implements EntryInterface
{
    
    function __construct()
    {
      $this->data = Incoming::withRelations()->orderBy('date_time','desc')->where('type',EntryType::Incoming->value);
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

            Log::debug("save incoming -- " . json_encode($data));

            self::validate($data);
            $entry = new Incoming();
            if (!empty($data['uuid'])) {
                $entry = Incoming::findFromUuid($data['uuid']);
            }

            $entry->account_id = $data['account_id'];
            $entry->amount = $data['amount'];
            $entry->category_id = $data['category_id'];
            $entry->currency_id = $data['currency_id'];
            $entry->date_time = $data['date_time'];
            $entry->note = $data['note'];
            $entry->payment_type = $data['payment_type'];
            $entry->installment = $data['installment'];

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
        Log::debug("read incoming -- $id");
        $result = new \stdClass();

        $entry = Incoming::withRelations()->where('type', EntryType::Incoming->value);

        if ($id === null) {
            $entry = $entry->get();
        } else {
            $entry = $entry->find($id);
        }

        if (!empty($entry)) {
            Log::debug("found incoming -- " . $entry->toJson());
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
            'amount' => ['required', 'numeric', 'gte:0'],
            'note' => 'nullable',
            'waranty' => 'boolean',
            'transfer' => 'boolean',
            'confirmed' => 'boolean',
            'planned' => 'boolean',
            'category_id' => ['required', 'integer'],
            'account_id' => ['required', 'integer'],
            'currency_id' => ['required', 'integer'],
            'payment_type' => ['required','integer'],
            'geolocation_id' => 'integer'
        ];

        Validator::validate($data, $rules);
    }
}

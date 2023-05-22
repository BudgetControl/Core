<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Debit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Models\Payee;
use Exception;

/**
 * Summary of SaveEntryService
 */
class DebitService extends EntryService implements EntryInterface
{
    function __construct()
    {
      $this->data = Debit::withRelations()->orderBy('date_time','desc')->where('type',EntryType::Debit->value);
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
            Log::debug("save debit -- " . json_encode($data));

            self::validate($data);

            $payeeService = new PayeeService();
            $payeeService->save([
                'name' => $data['payee_id']
            ]);

            $data['payee_id'] = Payee::where('name', $data['payee_id'])->firstOrFail('id')['id'];

            $entry = new Debit();
            if (!empty($data['uuid'])) {
                $entry = Debit::findFromUuid($data['uuid']);
            }

            $entry->account_id = $data['account_id'];
            $entry->amount = $data['amount'];
            $entry->currency_id = $data['currency_id'];
            $entry->date_time = $data['date_time'];
            $entry->note = $data['note'];
            $entry->payment_type = $data['payment_type'];
            $entry->payee_id = $data['payee_id'];

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
        Log::debug("read debit -- $id");
        $result = new \stdClass();

        $entry = Debit::withRelations()->user()->where('type', EntryType::Debit->value);

        if ($id === null) {
            $entry = $entry->get();
        } else {
            $entry = $entry->find($id);
        }

        if (!empty($entry)) {
            Log::debug("found debit -- " . $entry->toJson());
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
            'account_id' => ['required', 'integer'],
            'currency_id' => 'required|boolean',
            'payment_type' => ['required','integer'],
            'geolocation_id' => 'integer',
            'payee_id' => 'string'
        ];

        Validator::validate($data, $rules);
    }
}

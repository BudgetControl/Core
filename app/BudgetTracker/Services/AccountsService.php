<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use App\BudgetTracker\Models\Account;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\Rules\AccountType;

/**
 * Summary of SaveEntryService
 */
class AccountsService
{

    /**
     * save a resource
     * @param array $data
     * 
     * @return void
     */
    public function save(array $data): void
    {
        try {

            Log::debug("save Account -- " . json_encode($data));

            self::validate($data);
            $entry = new Account();
            if (!empty($data['uuid'])) {
                $entry = Account::findFromUuid($data['uuid']);
            }

            $entry->name = $data['name'];
            $entry->type = $data['type'];
            $entry->date_end = $data['date_end'];

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
        Log::debug("read accounts -- $id");
        $result = new \stdClass();

        $entry = Account::user();

        if ($id === null) {
            $entry = $entry->get();
        } else {
            $entry = $entry->find($id);
        }

        if (!empty($entry)) {
            Log::debug("found accounts -- " . $entry->toJson());
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
            'name' => ['required', 'string'],
            'date_end' => ['numeric', 'between:1,31'],
            'type' => ['required', new AccountType()],
            'color' => ['string','required']
        ];

        Validator::validate($data, $rules);
    }
}

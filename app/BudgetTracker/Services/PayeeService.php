<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Models\Payee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use League\Config\Exception\ValidationException;
use App\Rules\AmountMinor;

/**
 * Summary of SaveEntryService
 */
class PayeeService
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

            Log::debug("save payee -- " . json_encode($data));

            self::validate($data);

            $entry = Payee::where('name', $data['name'])->get();

            if ($entry->count() === 0) {
                $entry = new Payee();
                foreach ($data as $k => $v) {
                    $entry->$k = $v;
                }

                $entry->save();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
        Log::debug("read payee -- $id");
        $result = new \stdClass();

        if ($id === null) {
            $entry = Payee::all();
        } else {
            $entry = Payee::find($id);
        }

        if (!empty($entry)) {
            Log::debug("found payee -- " . $entry->toJson());
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
            'name' => 'string'
        ];

        Validator::validate($data, $rules);
    }
}

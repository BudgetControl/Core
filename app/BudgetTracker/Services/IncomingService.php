<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\DataObjects\Wallet;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Incoming as IncomingModel;
use App\BudgetTracker\Entity\Entries\Incoming;
use DateTime;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;

/**
 * Summary of SaveEntryService
 */
class IncomingService extends EntryService
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

            Log::debug("save incoming -- " . json_encode($data));

            $entry = new Incoming(
                $data['amount'],
                Currency::findOrFail($data['currency_id']),
                $data['note'],
                SubCategory::findOrFail($data['category_id']),
                Account::findOrFail($data['account_id']),
                PaymentsTypes::findOrFail($data['payment_type']),
                new DateTime($data['date_time']),
                $data['label'],
                $data['confirmed'],
                $data['waranty'],
            );

            $entryModel = new IncomingModel();
            if (!empty($data['uuid'])) {
                $entryModel = IncomingModel::findFromUuid($data['uuid']);
            }

            $this->updateBalance($entry,$entry->getAccount()->id,$entryModel);

            $entryModel->account_id = $entry->getAccount()->id;
            $entryModel->amount = $entry->getAmount();
            $entryModel->category_id = $entry->getCategory()->id;
            $entryModel->currency_id = $entry->getCurrency()->id;
            $entryModel->date_time = $entry->getDateFormat();
            $entryModel->note = $entry->getNote();
            $entryModel->payment_type = $entry->getPaymentType()->id;
            $entryModel->planned = $entry->getPlanned();
            $entryModel->waranty = $entry->getWaranty();
            $entryModel->confirmed = $entry->getConfirmed();
            $entryModel->user_id = UserService::getCacheUserID();

            $entryModel->save();

            $this->attachLabels($entry->getLabels(), $entryModel);

        } catch (\Exception $e) {
            $error = uniqid();
            Log::error("$error " . $e->getMessage());
            throw new \Exception("Ops an errro occurred " . $error);
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

        $entry = IncomingModel::withRelations()->user()->where('type', EntryType::Incoming->value);

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
     * retrive Incoming data of specific data
     */
    public function incomingFromData(DateTime $date): Wallet
    {
        $start = $date->format('Y-m-d h:i:s');

        $end = $date;
        $end->modify('last day of these month');
        $end = $date->format('Y-m-d h:i:s');

        $incoming = IncomingModel::where('date_time', '>=', $start)
        ->where('date_time', '<=', $end)->get();

        $wallet = new Wallet();
        $wallet->sum($incoming->toArray());

        return $wallet;
    }

 }

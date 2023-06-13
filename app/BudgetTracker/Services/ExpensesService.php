<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Expenses as ExpensesModel;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\Entity\Entries\Expenses;
use DateTime;

/**
 * Summary of SaveEntryService
 */
class ExpensesService extends EntryService
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

            Log::debug("save expenses -- " . json_encode($data));

            $entry = new Expenses(
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

            $entryModel = new ExpensesModel();
            if (!empty($data['uuid'])) {
                $entryModel = ExpensesModel::findFromUuid($data['uuid']);
            }

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

            $entryModel->save();

            $this->attachLabels($entry->getLabels(), $entryModel);
            if ($data['confirmed'] == 1) {
                AccountsService::updateBalance($entryModel->amount, $entryModel->account_id);
            }

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
        Log::debug("read expenses -- $id");
        $result = new \stdClass();

        $entry = ExpensesModel::withRelations()->user()->where('type', EntryType::Expenses->value);

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

}

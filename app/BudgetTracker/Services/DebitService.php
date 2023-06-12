<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Debit as DebitModel;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\ValueObject\Debit;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use Exception;
use DateTime;

/**
 * Summary of SaveEntryService
 */
class DebitService extends EntryService
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
            Log::debug("save debit -- " . json_encode($data));

            $payeeService = new PayeeService();
            $payeeService->save([
                'name' => $data['payee_id']
            ]);

            $data['payee_id'] = Payee::user()->where('name', $data['payee_id'])->firstOrFail('id')['id'];

            $entry = new Debit(
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

            $entryModel = new DebitModel();
            if (!empty($data['uuid'])) {
                $entryModel = DebitModel::findFromUuid($data['uuid']);
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
            $entryModel->payee = $entry->getPayee()->id;

            $entryModel->save();

            AccountsService::updateBalance($entryModel->amount, $entryModel->account_id);
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
        Log::debug("read debit -- $id");
        $result = new \stdClass();

        $entryModel = DebitModel::withRelations()->user()->where('type', EntryType::Debit->value);

        if ($id === null) {
            $entryModel = $entryModel->get();
        } else {
            $entryModel = $entryModel->find($id);
        }

        if (!empty($entryModel)) {
            Log::debug("found debit -- " . $entryModel->toJson());
            $result = $entryModel;
        }

        return $result;
    }
}

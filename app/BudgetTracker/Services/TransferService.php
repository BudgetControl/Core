<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Entity\Entries\Entry;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Transfer as TransferModel;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\Entity\Entries\Transfer;
use App\Http\Services\UserService;
use App\BudgetTracker\Models\Payee;
use Illuminate\Support\Facades\Log;
use DateTime;

/**
 * Summary of SaveEntryService
 */
class TransferService extends EntryService
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

            Log::debug("save transfer -- " . json_encode($data));
            $user_id = empty($data['user_id']) ? UserService::getCacheUserID() : $data['user_id'];

            $entry = new Transfer(
                $data['amount'],
                Currency::findOrFail($data['currency_id']),
                $data['note'],
                SubCategory::findOrFail(75),
                Account::findOrFail($data['account_id']),
                PaymentsTypes::findOrFail($data['payment_type']),
                new DateTime($data['date_time']),
                $data['label'],
                $data['confirmed'],
                $data['waranty'],
                $data['transfer_id'],
            );

            $entryModel = new TransferModel();
            if (!empty($data['uuid'])) {
                $entryModel = TransferModel::findFromUuid($data['uuid']);
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
            $entryModel->transfer_id = $data['transfer_id'];
            $entryModel->user_id = $user_id;
            $entryModel->save();

            $this->saveInverted($entry, $data['transfer_id'], $user_id);
            $this->updateBalance($entry, $entry->getAccount()->id, $entryModel);
            
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
    public function read(string|null $id = null): object
    {
        Log::debug("read entry -- $id");
        $result = new \stdClass();

        $entry = TransferModel::withRelations()->user()->where('type', EntryType::Transfer->value);

        if ($id === null) {
            $result = $entry->get();
        } else {
            $result = $entry->where('uuid',$id)->firstOrFail();
        }

        return $result;
    }

    /**
     * save inverted entry
     * @param Entry $entry
     * @param int $userId
     * 
     * @return void
     */
    private function saveInverted(Transfer $entry, int $userId): void
    {

        $transfer_id = $entry->getAccount()->id;
        $account_id = $entry->getTransfer_id();
        $amount = $entry->getAmount() * -1;

        $entryModel = new TransferModel();
        $entryModel->account_id = $account_id;
        $entryModel->amount = $amount;
        $entryModel->category_id = $entry->getCategory()->id;
        $entryModel->currency_id = $entry->getCurrency()->id;
        $entryModel->date_time = $entry->getDateFormat();
        $entryModel->note = $entry->getNote();
        $entryModel->payment_type = $entry->getPaymentType()->id;
        $entryModel->planned = $entry->getPlanned();
        $entryModel->waranty = $entry->getWaranty();
        $entryModel->confirmed = $entry->getConfirmed();
        $entryModel->transfer_id = $transfer_id;
        $entryModel->user_id = $userId;
        $entryModel->save();

        $this->updateBalance($entry, $account_id, $entryModel);

    }
}

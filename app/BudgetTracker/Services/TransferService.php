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
use App\BudgetTracker\Interfaces\EntryInterface;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Payee;
use Illuminate\Support\Facades\Log;
use DateTime;
use stdClass;

/**
 * Summary of SaveEntryService
 */
class TransferService extends EntryService
{   

    public function __construct(string $uuid = "")
    {
        parent::__construct($uuid);
    }

    /**
     * 
     */
    private function prepare(array $data): Transfer
    {
        $user_id = empty($data['user_id']) ? UserService::getCacheUserID() : $data['user_id'];
        $uuid = null;

        $entry = new Transfer(
            $data['amount'],
            Currency::findOrFail($data['currency_id']),
            $data['note'],
            new DateTime($data['date_time']),
            $data['waranty'],
            $data['confirmed'],
            Account::findOrFail($data['account_id']),
            PaymentsTypes::findOrFail($data['payment_type']),
            new \stdClass(),
            $data['label'],
            $data['transfer_id']
        );

        if(!empty($this->uuid)) {
            $transfer = TransferModel::findFromUuid($this->uuid,$user_id);
            if(!empty($transfer)) {
                $entry->setUuid($this->uuid);
            }
        }

        return $entry;
    }

    /**
     * 
     */
    private function prepareInverted(array $data): Transfer
    {

        $entry = new Transfer(
            $data['amount'] * -1,
            Currency::findOrFail($data['currency_id']),
            $data['note'],
            new DateTime($data['date_time']),
            $data['waranty'],
            $data['confirmed'],
            Account::findOrFail($data['transfer_id']),
            PaymentsTypes::findOrFail($data['payment_type']),
            new \stdClass(),
            $data['label'],
            $data['account_id']
        );

        //Is if a update?
        if(!empty($this->uuid)) {
            $transfer = TransferModel::findFromUuid($this->uuid);
            if(!empty($transfer)) {
                $entry->setUuid($transfer->transfer_relation);
            }
        }

        return $entry;

    }

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
        $user_id = empty($data['user_id']) ? UserService::getCacheUserID() : $data['user_id'];

        $transfer = $this->prepare($data);
        $transferInverted = $this->prepareInverted($data);

        $transfer->setTransfer_relation($transferInverted->getUuid());
        $transferInverted->setTransfer_relation($transfer->getUuid());

        $this->commitSave($transfer,$user_id);
        $this->commitSave($transferInverted,$user_id);

    }

    private function commitSave(Transfer $entry, int $userId): void
    {   

        $entryModel = new TransferModel();
        $walletService = new WalletService($entryModel);

        $findEntry = TransferModel::findFromUuid($entry->getUuid(),$userId);
        if (!empty($findEntry)) {
            $entryModel = $findEntry;
        }

        $entryModel->uuid = $entry->getUuid();
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
        $entryModel->transfer_relation = $entry->getTransfer_relation();
        $entryModel->transfer_id = $entry->getTransfer_id();
        $entryModel->user_id = $userId;
        $entryModel->save();

        $walletService->sum();
        $this->attachLabels($entry->getLabels(),$entryModel);

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

}

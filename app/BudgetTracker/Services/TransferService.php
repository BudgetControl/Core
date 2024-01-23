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
        $account = $data['account_id'] == 0 ? Account::where("uuid", Account::DEFAULT)->firstOrFail() : Account::findOrFail($data['account_id']);

        $entry = new Transfer(
            $data['amount'],
            Currency::findOrFail($data['currency_id']),
            $data['note'],
            new DateTime($data['date_time']),
            $data['waranty'],
            $data['confirmed'],
            $account,
            PaymentsTypes::findOrFail($data['payment_type']),
            new \stdClass(),
            $data['label'],
            $data['transfer_id']
        );

        if(!empty($this->uuid)) {
            $entry->setUuid($this->uuid);
        }

        return $entry;
    }

    /**
     * 
     */
    private function prepareInverted(array $data): Transfer
    {
        $account = $data['transfer_id'] == 0 ? Account::where("uuid", Account::DEFAULT)->firstOrFail() : Account::findOrFail($data['transfer_id']);

        $entry = new Transfer(
            $data['amount'] * -1,
            Currency::findOrFail($data['currency_id']),
            $data['note'],
            new DateTime($data['date_time']),
            $data['waranty'],
            $data['confirmed'],
            $account,
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

        $transfer = $this->prepare($data);
        $transferInverted = $this->prepareInverted($data);

        $transfer->setTransfer_relation($transferInverted->getUuid());
        $transferInverted->setTransfer_relation($transfer->getUuid());

        $this->commitSave($transfer);
        $this->commitSave($transferInverted);

    }

    private function commitSave(Transfer $entry): void
    {   

        $entryModel = new TransferModel();

        $findEntry = TransferModel::findFromUuid($entry->getUuid());
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

        $walletService = new WalletService(
            EntryService::create($entryModel->toArray(), EntryType::Transfer)
        );
        $walletService->sum();

        $entryModel->save();

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

        $entry = TransferModel::withRelations()->where('type', EntryType::Transfer->value);

        if ($id === null) {
            $result = $entry->get();
        } else {
            $result = $entry->where('uuid',$id)->firstOrFail();
        }

        return $result;
    }

}

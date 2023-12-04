<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Incoming as IncomingModel;
use App\BudgetTracker\Entity\Entries\Incoming;
use App\BudgetTracker\Models\Labels;
use DateTime;
use Illuminate\Support\Facades\Log;
use App\User\Services\UserService;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\Models\Payee;

/**
 * Summary of SaveEntryService
 */
class IncomingService extends EntryService
{

    public function __construct(string $uuid = "")
    {
        parent::__construct($uuid);
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
        try {

            Log::debug("save incoming -- " . json_encode($data));

            $entry = new Incoming(
                $data['amount'],
                Currency::findOrFail($data['currency_id']),
                $data['note'],
                new DateTime($data['date_time']),
                $data['waranty'],
                $data['confirmed'],
                SubCategory::findOrFail($data['category_id']),
                Account::findOrFail($data['account_id']),
                PaymentsTypes::findOrFail($data['payment_type']),
                new \stdClass(),
                $data['label']
            );

            $entryModel = new IncomingModel();
            if (!empty($this->uuid)) {
                $entry->setUuid($this->uuid);
                $entryDb = Entry::findFromUuid($this->uuid);
                $entryModel = $entryDb;
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
            $entryModel->type = EntryType::Incoming->value;
            $entryModel->user_id = empty($data['user_id']) ? UserService::getCacheUserID() : $data['user_id'];
            //TODO: fixme
            if(!is_null($payee)) {
                $entryModel->payee_id = $payee->id;
            }
            
            $walletService = new WalletService(
                EntryService::create($entryModel->toArray(), EntryType::Incoming)
            );
            $walletService->sum();
            
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
    public function read(string|int|null $id = null): object
    {
        Log::debug("read incoming -- $id");
        $result = new \stdClass();

        $entry = IncomingModel::withRelations()->user()->where('type', EntryType::Incoming->value);

        if ($id === null) {
            $result = $entry->get();
        } else {
            $result = $entry->where('uuid',$id)->firstOrFail();
        }

        return $result;
    }

 }

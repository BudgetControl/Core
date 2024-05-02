<?php

namespace App\BudgetTracker\Services;

use DateTime;
use Exception;
use Illuminate\Support\Carbon;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Payee;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Entity\Entries\Debit;
use App\BudgetTracker\Models\PaymentsTypes;
use App\BudgetTracker\Models\Debit as DebitModel;

/**
 * Summary of SaveEntryService
 */
class DebitService extends EntryService
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
            Log::debug("save debit -- " . json_encode($data));

            $payeeService = new PayeeService();
            $payeeService->save([
                'name' => $data['payee_id']
            ]);

            $payee = Payee::where('name', $data['payee_id'])->firstOrFail();

            $entry = new Debit(
                $data['amount'],
                Currency::findOrFail($data['currency_id']),
                $data['note'],
                new DateTime($data['date_time']),
                $data['confirmed'],
                Account::findOrFail($data['account_id']),
                PaymentsTypes::findOrFail($data['payment_type']),
                new \stdClass(), //geoloc
                $data['label'],
                $payee,
            );

            $entryModel = new DebitModel();
            if (!empty($this->uuid)) {
                $entry->setUuid($this->uuid);
                $entryDb = Entry::findFromUuid($this->uuid);
                $entryModel = $entryDb;
            }

            $entryModel->uuid = $entry->getUuid();
            $entryModel->account_id = $entry->getAccount()->id;
            $entryModel->amount = $entry->getAmount();
            $entryModel->currency_id = $entry->getCurrency()->id;
            $entryModel->date_time = Carbon::parse($entry->getDateFormat())->toAtomString();
            $entryModel->note = $entry->getNote();
            $entryModel->payment_type = $entry->getPaymentType()->id;
            $entryModel->planned = $entry->getPlanned();
            $entryModel->waranty = $entry->getWaranty();
            $entryModel->confirmed = $entry->getConfirmed();
            $entryModel->payee_id = $entry->getPayee()->id;
            
            $walletService = new WalletService(
                EntryService::create($entryModel->toArray(), EntryType::Debit)
            );
            $walletService->sum();
            
            $entryModel->save();

    
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
        Log::debug("read debit -- $id");
        $result = new \stdClass();

        $entryModel = DebitModel::User()->withRelations()->where('type', EntryType::Debit->value);

        if ($id === null) {
            $result = $entryModel->get();
        } else {
            $result = $entryModel->where('uuid',$id)->firstOrFail();
        }

        return $result;
    }
}

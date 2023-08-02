<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Debit as DebitModel;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Entity\Entries\Debit;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\Http\Services\UserService;
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
   * @param EntryType|null $type
   * @param Payee|null $payee
   * 
   * @return void
   */
  public function save(array $data, EntryType|null $type = null, Payee|null $payee = null): void
    {
        try {
            Log::debug("save debit -- " . json_encode($data));

            $payeeService = new PayeeService();
            $payeeService->save([
                'name' => $data['payee_id']
            ]);

            $payee = Payee::user()->where('name', $data['payee_id'])->firstOrFail();

            $entry = new Debit(
                $data['amount'],
                Currency::findOrFail($data['currency_id']),
                $data['note'],
                SubCategory::findOrFail(DebitModel::DEFAULT_CATEGORY),
                Account::findOrFail($data['account_id']),
                PaymentsTypes::findOrFail($data['payment_type']),
                new DateTime($data['date_time']),
                $data['label'],
                $data['confirmed'],
                $data['waranty'],
                0,
                new \stdClass(),
                false,
                $payee,
            );

            $entryModel = new DebitModel();
            if (!empty($data['uuid'])) {
                $entryModel = DebitModel::findFromUuid($data['uuid']);
            }

            $entryModel->account_id = $entry->getAccount()->id;
            $entryModel->amount = $entry->getAmount();
            $entryModel->currency_id = $entry->getCurrency()->id;
            $entryModel->date_time = $entry->getDateFormat();
            $entryModel->note = $entry->getNote();
            $entryModel->payment_type = $entry->getPaymentType()->id;
            $entryModel->planned = $entry->getPlanned();
            $entryModel->waranty = $entry->getWaranty();
            $entryModel->confirmed = $entry->getConfirmed();
            $entryModel->payee_id = $entry->getPayee()->id;
            $entryModel->user_id = empty($data['user_id']) ? UserService::getCacheUserID() : $data['user_id'];
            $entryModel->save();
            
            $this->updateBalance($entry,$entry->getAccount()->id,$entryModel);

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
        Log::debug("read debit -- $id");
        $result = new \stdClass();

        $entryModel = DebitModel::withRelations()->user()->where('type', EntryType::Debit->value);

        if ($id === null) {
            $result = $entryModel->get();
        } else {
            $result = $entryModel->where('uuid',$id)->firstOrFail();
        }

        return $result;
    }
}

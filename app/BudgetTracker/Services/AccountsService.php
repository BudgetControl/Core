<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Models\Account;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Entity\Accounts\BankAccount;
use App\BudgetTracker\Entity\Accounts\CreditCardAccount;
use App\BudgetTracker\Entity\Accounts\SavingAccount;
use App\BudgetTracker\Interfaces\AccountInterface;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use App\BudgetTracker\Entity\Wallet;
use App\Http\Services\UserService;

/**
 * Summary of SaveEntryService
 */
class AccountsService
{
    /** @var AccountInterface */
    private $account;

    /**
     * save a resource
     * @param array $data
     * 
     * @return void
     * @throws \Exception
     */
    public function save(array $data): void
    {
        try {

            Log::debug("save Account -- " . json_encode($data));

            $this->makeObject($data);

            $account = $this->account->toArray();

            $entry = new Account();
            if (!empty($data['uuid'])) {
                $entry = Account::findFromUuid($data['uuid']);
            }

            $entry->name = $account['name'];
            $entry->type = $account['type'];
            $entry->date = $account['date'];
            $entry->color = $account['color'];
            $entry->balance = $account['balance'];
            $entry->installement = $account['installement'];
            $entry->installementValue = $account['installementValue'];
            $entry->currency = $account['currency'];
            $entry->amount = $account['amount'];
            $entry->user_id = empty($data['user_id']) ? UserService::getCacheUserID() : $data['user_id'];;

            $entry->save();
            
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
     * @return AccountInterface with a resource
     * @throws \Exception
     */
    public function read(int $id = null): Collection
    {
        Log::debug("read accounts -- $id");

        $entry = Account::user();

        if ($id === null) {
            $entry = $entry->get();
        } else {
            $entry = $entry->firstOrFail($id);
        }

        return $entry;
    }

    /**
     * make object to save
     * @param array $data
     * 
     * @return void
     * @throws \Exception
     */
    private function makeObject(array $data): void
    {
        switch ($data['type']) {
            case 'CreditCard':
                $this->account = new CreditCardAccount($data['name'], $data['currency'], $data['color'], $data['balance'], $this->makeTime($data['date']), $data['installement'], $data['installementValue']);
                break;
            case 'Bank':
                $this->account = new BankAccount($data['name'], $data['currency'], $data['color'], $data['balance']);
                break;
            case 'Saving':
                $this->account = new SavingAccount($data['name'], $data['currency'], $data['color'], $data['amount'], $data['balance'], $this->makeTime($data['date']));
                break;
            default:
                throw new \Exception("Account type is ivalid");
        }
    }

    /**
     * make time
     * @param string $dateTime
     * 
     * @return DateTime
     */
    private function makeTime(string $dateTime): DateTime
    {
        return new DateTime($dateTime);
    }

    /**
     * update balance
     * @param float $amount
     * @param int $account_id
     * 
     * @return void
     */
    public static function updateBalance(float $amount, int $account_id):void
    {
        $account = Account::findOrFail($account_id);
        $wallet = new Wallet($account->balance);
        $wallet->deposit($amount);

        $account->balance = $wallet->getBalance();
        $account->save();
    }
}

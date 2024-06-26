<?php

namespace App\BudgetTracker\Services;

use DateTime;
use Illuminate\Support\Carbon;
use App\User\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Entity\Wallet;
use App\BudgetTracker\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\BudgetTracker\Entity\Accounts\BankAccount;
use App\BudgetTracker\Entity\Accounts\CashAccount;
use App\BudgetTracker\Interfaces\AccountInterface;
use App\BudgetTracker\Entity\Accounts\SavingAccount;
use App\BudgetTracker\Entity\Accounts\CreditCardAccount;
use App\BudgetTracker\Entity\Accounts\InvestmentAccount;
use App\BudgetTracker\Entity\Accounts\CreditCardRevolvingAccount;

/**
 * Summary of SaveEntryService
 */
class AccountsService
{
    /** @var AccountInterface */
    private $account;
    private int|null $id;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }

    public function all()
    {
        return Account::Sorting()->User()->get();
    }

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

            if(empty($data['exclude_from_stats'])) {
                $data['exclude_from_stats'] = false;
            }

            $this->makeObject($data);
            $account = $this->account->toArray();
            $entry = new Account();
            if (!empty($this->id)) {
                $entry = Account::findOrFail($this->id);
            }

            $entry->name = $account['name'];
            $entry->type = $account['type'];
            $entry->color = $account['color'];
            $entry->balance = $account['balance'];
            $entry->currency = $account['currency'];
            $entry->exclude_from_stats = $account['exclude_from_stats'];
            $entry->date = empty(@$account['date']) ? null : Carbon::parse($account['date'])->toAtomString();

            if(!empty($account['installement'])) {
                $entry->installement = $account['installement'];
                $entry->installementValue = $account['installementValue'];
            }

            $entry->save();
            
        } catch (\Exception $e) {
            $error = \Ramsey\Uuid\Uuid::uuid4()->toString();;
            Log::error("$error " . $e->getMessage());
            throw new \Exception("Ops an errro occurred " . $error);
        }
    }

    /**
     * save sorting data
     * @param int $accountID id
     * @param int $sorting
     * 
     * @return void
     */
    public function sorting(int $sorting): void
    {
        $accounts = Account::where("sorting", '>=', $sorting)->get();
        $sort = $sorting;
        foreach($accounts as $acocunt) {
            $sort++;
            $acocunt->update([
                'sorting' => $sort
            ]);
        }

        Account::findOrFail($this->id)->update([
            'sorting' => $sorting
        ]);
    }

    /**
     * read a resource
     * @param int $id of resource
     * 
     * @return Model with a resource
     * @throws \Exception
     */
    public function read(int $id = null ): Model
    {

        if ($id === null) {
            $accounts = Account::User()->get();
        } else {
            $accounts = Account::where("id", $id)->withTrashed()->firstOrFail();
        }

        return $accounts;
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
        if(empty($data['date'])) {
            $data['date'] = date("Y-m-d H:i:s");
        }
        
        switch (trim($data['type'])) {
            case 'Credit Card':
                $this->account = new CreditCardAccount($data['name'], $data['currency'], $data['color'], $data['balance'], $this->makeTime($data['date']), $data['exclude_from_stats']);
                break;
            case 'Credit Card Revolving':
                $this->account = new CreditCardRevolvingAccount($data['name'], $data['currency'], $data['color'], $data['balance'], $this->makeTime($data['date']), $data['installementValue'],$data['exclude_from_stats']);
                break;
            case 'Bank':
                $this->account = new BankAccount($data['name'], $data['currency'], $data['color'], $data['balance'],$data['exclude_from_stats']);
                break;
            case 'Saving':
                $this->account = new SavingAccount($data['name'], $data['currency'], $data['color'], $data['balance'], $this->makeTime($data['date']),$data['exclude_from_stats']);
                break;
            case 'Cash':
                $this->account = new CashAccount($data['name'], $data['currency'], $data['color'], $data['balance'], $this->makeTime($data['date']),$data['exclude_from_stats']);
                break;
            case 'Investment':
                $this->account = new InvestmentAccount($data['name'], $data['currency'], $data['color'], $data['balance'], $data['exclude_from_stats']);
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

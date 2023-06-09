<?php

namespace App\BudgetTracker\Services;

use App\BudgetTracker\Models\Account;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\ValueObject\Accounts\BankAccount;
use App\BudgetTracker\ValueObject\Accounts\CreditCardAccount;
use App\BudgetTracker\ValueObject\Accounts\SavingAccount;
use App\BudgetTracker\Interfaces\AccountInterface;
use DateTime;

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
            $entry->value = $account['value'];
            $entry->installement = $account['installement'];
            $entry->installementValue = $account['installementValue'];
            $entry->currency = $account['currency'];
            $entry->amount = $account['amount'];

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
    public function read(int $id = null): AccountInterface
    {
        Log::debug("read accounts -- $id");

        $entry = Account::user();

        if ($id === null) {
            $entry = $entry->get();
        } else {
            $entry = $entry->firstOrFail($id);
        }

        $this->makeObject($entry->toArray());

        return $this->account;
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
                $this->account = new CreditCardAccount($data['name'], $data['currency'], $data['color'], $data['value'], $this->makeTime($data['date']), $data['installement'], $data['installementValue']);
                break;
            case 'Bank':
                $this->account = new BankAccount($data['name'], $data['currency'], $data['color'], $data['value']);
                break;
            case 'Saving':
                $this->account = new SavingAccount($data['name'], $data['currency'], $data['color'], $data['amount'], $data['value'], $this->makeTime($data['date']));
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
}

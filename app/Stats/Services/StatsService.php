<?php

namespace App\Stats\Services;

use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Entity\Wallet;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Category;
use App\BudgetTracker\Models\Debit;
use App\BudgetTracker\Models\Expenses;
use App\BudgetTracker\Models\Investments;
use App\BudgetTracker\Models\SubCategory;
use App\BudgetTracker\Models\Transfer;
use App\User\Services\UserService;
use App\Helpers\MathHelper;
use DateTime;
use Exception;

class StatsService
{

    private string $startDate;
    private string $endDate;
    private string $startDatePassed;
    private string $endDatePassed;

    public function __construct(?string $startDate = null, ?string $endDate = null)
    {
        if (is_null($startDate)) {
            // Primo giorno del mese corrente
            $startDate = date('Y-m-01');
        }

        if (is_null($endDate)) {
            // Ultimo giorno del mese corrente
            $endDate = date('Y-m-t');
        }

        $this->setDateEnd($endDate);
        $this->setDateStart($startDate);
    }

    /**
     * set data to start stats
     * @param string $date
     * 
     * @return void
     */
    private function setDateStart(string $date): void
    {
        $this->startDate = $date;

        $passedDateTime = new DateTime($date);
        $passedDateTime = $passedDateTime->modify('-1 month');
        $this->startDatePassed = $passedDateTime->format('Y-m-d H:i:s');

    }

    /**
     * set data to start stats
     * @param string $date
     * 
     * @return self
     */
    private function setDateEnd(string $date): void
    {
        $this->endDate = $date;

        $passedDateTime = new DateTime($date);
        $passedDateTime = $passedDateTime->modify('-1 month');
        $this->endDatePassed = $passedDateTime->format('Y-m-d H:i:s');

    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return array
     */
    public function incoming(bool $planning): array
    {
        $categories = $this->getCategoryId(EntryType::Incoming->value);

        $entry = Incoming::user();
        $entry->where('date_time', '<=', $this->endDate)
        ->where('date_time', '>=', $this->startDate)->whereIn('category_id', $categories);

        $entryOld = Incoming::user();
        $entryOld->where('date_time', '<=', $this->endDatePassed)
        ->where('date_time', '>=', $this->startDatePassed)->whereIn('category_id', $categories);

        if ($planning === true) {
            $entry->whereIn('planned',[0,1]);
            $entryOld->whereIn('planned',[0,1]);
        } else {
            $entry->where('planned',0);
            $entryOld->where('planned',0);
        }

        $response = $this->buildResponse($entry->get()->toArray(), $entryOld->get()->toArray());

        return $response;

    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return array
     */
    public function investments(bool $planning): array
    {
        $categories = $this->getCategoryId(EntryType::Investments->value);

        $entry = Investments::user();
        $entry->where('date_time', '<=', $this->endDate)
        ->where('date_time', '>=', $this->startDate)->whereIn('category_id', $categories);

        $entryOld = Investments::user();
        $entryOld->where('date_time', '<=', $this->endDatePassed)
        ->where('date_time', '>=', $this->startDatePassed)->whereIn('category_id', $categories);

        if ($planning === true) {
            $entry->whereIn('planned',[0,1]);
            $entryOld->whereIn('planned',[0,1]);
        } else {
            $entry->where('planned',0);
            $entryOld->where('planned',0);
        }

        $response = $this->buildResponse($entry->get()->toArray(), $entryOld->get()->toArray());

        return $response;

    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return array
     */
    public function expenses(bool $planning): array
    {
        $categories = $this->getCategoryId(EntryType::Expenses->value);

        $entry = Expenses::user();
        $entry->where('date_time', '<=', $this->endDate)
        ->where('date_time', '>=', $this->startDate)->whereIn('category_id', $categories);

        $entryOld = Expenses::user();
        $entryOld->where('date_time', '<=', $this->endDatePassed)
        ->where('date_time', '>=', $this->startDatePassed)->whereIn('category_id', $categories);

        if ($planning === true) {
            $entry->whereIn('planned',[0,1]);
            $entryOld->whereIn('planned',[0,1]);
        } else {
            $entry->where('planned',0);
            $entryOld->where('planned',0);
        }

        $response = $this->buildResponse($entry->get()->toArray(), $entryOld->get()->toArray());

        return $response;

    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return array
     */
    public function transfer(bool $planning): array
    {
        $entry = Transfer::user();
        $entry->where('date_time', '<=', $this->endDate)
        ->where('date_time', '>=', $this->startDate)->where('type',EntryType::Transfer->value);

        $entryOld = Transfer::user();
        $entryOld->where('date_time', '<=', $this->endDatePassed)
        ->where('date_time', '>=', $this->startDatePassed)->where('type',EntryType::Transfer->value);

        $response = $this->buildResponse($entry->get()->toArray(), $entryOld->get()->toArray());

        return $response;

    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return array
     */
    public function debit(): array
    {
        $entry = Debit::user();
        $entry->where('date_time', '<=', $this->endDate)
        ->where('date_time', '>=', $this->startDate)->where('type',EntryType::Debit->value);

        $entryOld = Debit::user();
        $entryOld->where('date_time', '<=', $this->endDatePassed)
        ->where('date_time', '>=', $this->startDatePassed)->where('type',EntryType::Debit->value);

        $response = $this->buildResponse($entry->get()->toArray(), $entryOld->get()->toArray());

        return $response;
    }

    /**
     * retrive total wallet sum
     * @param bool $planning
     * 
     * @return float
     */
    public function total(bool $planning): float
    {
        $wallet = new Wallet(0);

        $accounts = Account::user()->where('installement',0)->get();
        foreach($accounts as $account) {
            $wallet->deposit($account->balance);
        }

        if ($planning === true) {
            $plannedEntries = $this->getPlannedEntry();
            $installementValue = $this->getInstallementValue();
            $entries = array_merge($plannedEntries->toArray(),$installementValue->toArray());
            $wallet->sum($entries);
        }

        return $wallet->getBalance();
    }

    /**
     * get only planned entry
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getPlannedEntry(): \Illuminate\Database\Eloquent\Collection
    {
        $dateTime = new DateTime('now');
        $dateTime = $dateTime->modify('Last day of this month');
        $dateTime = $dateTime->format('Y-m-d H:i:s');

        $dateTimeFirst = new DateTime('now');
        $dateTimeFirst = $dateTimeFirst->modify('First day of this month');
        $dateTimeFirst = $dateTimeFirst->format('Y-m-d H:i:s');

        $entry = Entry::leftJoin('accounts', 'accounts.id', '=', 'entries.account_id')
            ->where('entries.planned', 1)
            ->where('entries.date_time', '<=', $dateTime)
            ->where('entries.date_time', '>=', $dateTimeFirst)
            ->where('accounts.installement', 0)
            ->where('accounts.user_id',UserService::getCacheUserID())
            ->get('entries.amount');

        return $entry;
    }

    private function getInstallementValue(): \Illuminate\Database\Eloquent\Collection
    {
        return Account::user()->where('installement', 1)->get('installementValue as amount');
    }

    /** 
     * retrive all accounts
     * @param bool $planning
     * @param \Illuminate\Database\Eloquent\Collection $accounts
     * 
     * @return array
     */
    public function wallets(\Illuminate\Database\Eloquent\Collection $accounts): array
    {
        $response = [];
        foreach ($accounts as $account) {

            $wallet = new Wallet($account->balance);

            $response[] = [
                'account_id' => $account->id,
                'account_label' => $account->name,
                'color' => $account->color,
                'total_wallet' => $wallet->getBalance()
            ];
        }

        return $response;
    }

    /**
     * get the healt of wallet
     */
    public function health(bool $planned): float
    {
        $wallet = new Wallet(0);

        $accounts = Account::user()->get();
        foreach($accounts as $account) {
            $wallet->deposit($account->balance);
        }

        return $wallet->getBalance();
    }

    /**
     * build stats standard response
     * @param array $data
     * @param array $dataOld
     * 
     * @return array
     */
    private function buildResponse(array $data, array $dataOld)
    {
        $wallet = new Wallet();
        $wallet->sum($data);

        $walletPassed = new Wallet();
        $walletPassed->sum($dataOld);

        $firstValue = $wallet->getBalance();
        $secondValue = $walletPassed->getBalance();

        return [
            'total' => $firstValue,
            'total_passed' => $secondValue,
            'percentage' => MathHelper::percentage($firstValue, $secondValue)
        ];
    }

    /**
     *  retrive only category id
     */
    private function getCategoryId(string $type): array
    {
        $results = [];
        $categories = Category::getCateroyGroup($type);
        foreach($categories as $cat) {
            $results[] = $cat->id;
        }

        if(empty($results)) {
            throw new Exception("Ops no category foud with type ( $type )", 500);
        }

        return $results;
    }

}

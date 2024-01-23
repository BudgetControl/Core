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
use App\BudgetTracker\Models\Transfer;
use App\User\Services\UserService;
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
        $entry = Incoming::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)->where('entries.type', EntryType::Incoming->value);

        $entryOld = Incoming::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)->where('entries.type', EntryType::Incoming->value);

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
    public function entryByCategory(array $categoryID, bool $planning): array
    {
        $entry = Entry::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)->whereIn('category_id', $categoryID);

        $entryOld = Entry::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)->whereIn('category_id', $categoryID);

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
    public function entryByType(array $type, bool $planning): array
    {
        $entry = Entry::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)->where('entries.type', $type);

        $entryOld = Entry::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)->where('entries.type', $type);

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
        $entry = Investments::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)->where('entries.type', EntryType::Investments->value);

        $entryOld = Investments::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)->where('entries.type', EntryType::Investments->value);

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
        $entry = Expenses::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)->where('entries.type', EntryType::Expenses->value);

        $entryOld = Expenses::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)->where('entries.type', EntryType::Expenses->value);

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
    public function entryByLabel(array $labelsID, bool $planning): array
    {
        $entry = Entry::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)
        ->leftJoin('entry_labels', "entry_labels.entry_id","=","entries.id")
        ->leftJoin('labels', "labels.id","=","entry_labels.labels_id")
        ->whereIn("labels.id",$labelsID);

        $entryOld = Entry::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)
        ->leftJoin('entry_labels', "entry_labels.entry_id","=","entries.id")
        ->leftJoin('labels', "labels.id","=","entry_labels.labels_id")
        ->whereIn("labels.id",$labelsID);

        if ($planning === true) {
            $entry->whereIn('entries.planned',[0,1]);
            $entryOld->whereIn('entries.planned',[0,1]);
        } else {
            $entry->where('entries.planned',0);
            $entryOld->where('entries.planned',0);
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
        $entry = Transfer::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)->where('entries.type',EntryType::Transfer->value);

        $entryOld = Transfer::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)->where('entries.type',EntryType::Transfer->value);

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
        $entry = Debit::stats();
        $entry->where('entries.date_time', '<=', $this->endDate)
        ->where('entries.date_time', '>=', $this->startDate)->where('entries.type',EntryType::Debit->value);

        $entryOld = Debit::stats();
        $entryOld->where('entries.date_time', '<=', $this->endDatePassed)
        ->where('entries.date_time', '>=', $this->startDatePassed)->where('entries.type',EntryType::Debit->value);

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

        $accounts = Account::stats()->where('installement',0)->get();
        foreach($accounts as $account) {
            $wallet->deposit($account->balance);
        }

        if ($planning === true) {
            $plannedEntries = $this->getPlannedEntry();
            $installementValue = $this->getInstallementValue();
            $entries = array_merge($plannedEntries->toArray(),$installementValue);
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
            ->where('accounts.exclude_from_stats', 0)
            ->get('entries.amount');

        return $entry;
    }

    private function getInstallementValue(): array
    {
        $values = Account::stats()->where('installement', 1)->get();
        $data = [];
        foreach($values as $value) {
            $balance = $value->balance * -1;
            if($balance <= $value->installementValue) {
                $data[] = ['amount' => $value->balance];
            } else {
                $data[] = ['amount' => $value->installementValue * -1];
            }
        }

        return $data;
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

        $accounts = Account::stats()->get();
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
            'percentage' => percentage($firstValue, $secondValue)
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

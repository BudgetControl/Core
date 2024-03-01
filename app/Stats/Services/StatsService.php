<?php

namespace App\Stats\Services;

use App\BudgetTracker\Entity\DateTime as EntityDateTime;
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
use App\Stats\Domain\Repository\StatsRepository;
use App\User\Services\UserService;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;

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
    public function entryByCategory(array $categoryID, bool $planning): array
    {
        $entry = Entry::stats()->User();
        $entry->whereBetween('entries.date_time', [$this->startDate, $this->endDate])->whereIn('category_id', $categoryID);

        $entryOld = Entry::stats()->User();
        $entryOld->whereBetween('entries.date_time', [$this->startDatePassed, $this->endDatePassed])->whereIn('category_id', $categoryID);

        if ($planning === true) {
            $entry->whereIn('planned', [0, 1]);
            $entryOld->whereIn('planned', [0, 1]);
        } else {
            $entry->where('planned', 0);
            $entryOld->where('planned', 0);
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
        $entry = Entry::stats()->User();
        $entry->whereBetween('entries.date_time', [$this->startDate, $this->endDate])->where('entries.type', $type);

        $entryOld = Entry::stats()->User();
        $entryOld->whereBetween('entries.date_time', [$this->startDatePassed, $this->endDatePassed])->where('entries.type', $type);

        if ($planning === true) {
            $entry->whereIn('planned', [0, 1]);
            $entryOld->whereIn('planned', [0, 1]);
        } else {
            $entry->where('planned', 0);
            $entryOld->where('planned', 0);
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
        $entry = Investments::stats()->User();
        $entry->whereBetween('entries.date_time', [$this->startDate, $this->endDate])->where('entries.type', EntryType::Investments->value);

        $entryOld = Investments::stats()->User();
        $entryOld->whereBetween('entries.date_time', [$this->startDatePassed, $this->endDatePassed])->where('entries.type', EntryType::Investments->value);

        if ($planning === true) {
            $entry->whereIn('planned', [0, 1]);
            $entryOld->whereIn('planned', [0, 1]);
        } else {
            $entry->where('planned', 0);
            $entryOld->where('planned', 0);
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
    public function incoming(): array
    {
        $previousDate = strtotime($this->startDatePassed);
        $currentDate = strtotime($this->startDate);

        $statsRepository = new StatsRepository();
        $totalAmount = $statsRepository->statsMonthIncoming(
            date('m', $currentDate),
            date('Y', $currentDate),
        );

        $totalAmountBefore = $statsRepository->statsMonthIncoming(
            date('m', $previousDate),
            date('Y', $previousDate),
        );

        $response = $this->buildResponse($totalAmount->toArray(), $totalAmountBefore->toArray());

        return $response;
    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return array
     */
    public function expenses(): array
    {
        $previousDate = strtotime($this->startDatePassed);
        $currentDate = strtotime($this->startDate);

        $statsRepository = new StatsRepository();
        $totalAmount = $statsRepository->statsMonthExpenses(
            date('m', $currentDate),
            date('Y', $currentDate),
        );

        $totalAmountBefore = $statsRepository->statsMonthExpenses(
            date('m', $previousDate),
            date('Y', $previousDate),
        );

        $response = $this->buildResponse($totalAmount->toArray(), $totalAmountBefore->toArray());

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
        $entry = Entry::stats()->User();
        $entry->whereBetween('entries.date_time', [$this->startDate, $this->endDate])
            ->leftJoin('entry_labels', "entry_labels.entry_id", "=", "entries.id")
            ->leftJoin('labels', "labels.id", "=", "entry_labels.labels_id")
            ->whereIn("labels.id", $labelsID);

        $entryOld = Entry::stats()->User();
        $entryOld->whereBetween('entries.date_time', [$this->startDatePassed, $this->endDatePassed])
            ->leftJoin('entry_labels', "entry_labels.entry_id", "=", "entries.id")
            ->leftJoin('labels', "labels.id", "=", "entry_labels.labels_id")
            ->whereIn("labels.id", $labelsID);

        if ($planning === true) {
            $entry->whereIn('entries.planned', [0, 1]);
            $entryOld->whereIn('entries.planned', [0, 1]);
        } else {
            $entry->where('entries.planned', 0);
            $entryOld->where('entries.planned', 0);
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
        $entry = Transfer::stats()->User();
        $entry->whereBetween('entries.date_time', [$this->startDate, $this->endDate])->where('entries.type', EntryType::Transfer->value);

        $entryOld = Transfer::stats()->User();
        $entryOld->whereBetween('entries.date_time', [$this->startDatePassed, $this->endDatePassed])->where('entries.type', EntryType::Transfer->value);

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
        $entry = Debit::stats()->User();
        $entry->whereBetween('entries.date_time', [$this->startDate, $this->endDate])->where('entries.type', EntryType::Debit->value);

        $entryOld = Debit::stats()->User();
        $entryOld->whereBetween('entries.date_time', [$this->startDatePassed, $this->endDatePassed])->where('entries.type', EntryType::Debit->value);

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

        $accounts = Account::stats()->User()->where('installement', 0)->get();
        foreach ($accounts as $account) {
            $wallet->deposit($account->balance);
        }

        if ($planning === true) {
            $plannedEntries = $this->getPlannedEntry();
            $installementValue = $this->getInstallementValue();
            $entries = array_merge($plannedEntries->toArray(), $installementValue);
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
            ->User()
            ->get('entries.amount');

        return $entry;
    }

    private function getInstallementValue(): array
    {
        $values = Account::stats()->User()->where('installement', 1)->get();
        $data = [];
        foreach ($values as $value) {
            $balance = $value->balance * -1;
            if ($balance <= $value->installementValue) {
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

        $accounts = Account::stats()->User()->get();
        foreach ($accounts as $account) {
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
        foreach ($categories as $cat) {
            $results[] = $cat->id;
        }

        if (empty($results)) {
            throw new Exception("Ops no category foud with type ( $type )", 500);
        }

        return $results;
    }

    /**
     * generate array map
     * @param array $entry
     * @param array $entryOld
     * 
     * @return array
     */
    private function map( array $entry, array $entryOld): array
    {
        $entry = array_map(function ($entry) {
            return (array) $entry;
        }, $entry);

        $entryOld = array_map(function ($entryOld) {
            return (array) $entryOld;
        }, $entryOld);

        return [$entry, $entryOld];
    }
}

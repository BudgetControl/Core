<?php

namespace App\Stats\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Services\DebitService;
use App\BudgetTracker\Services\EntryService;
use App\BudgetTracker\Services\ExpensesService;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Services\IncomingService;
use App\BudgetTracker\Services\TransferService;
use App\BudgetTracker\Enums\Action;
use App\BudgetTracker\Models\ActionJobConfiguration;
use App\BudgetTracker\Models\Entry;
use Illuminate\Support\Facades\Log;
use App\Helpers\EntriesMath;
use App\Helpers\MathHelper;
use Database\Seeders\TransferSeed;
use DateTime;
use \Illuminate\Http\JsonResponse;
use League\CommonMark\Extension\CommonMark\Parser\Inline\EntityParser;

class StatsController extends Controller
{

    private string $startDate;
    private string $endDate;
    private string $startDatePassed;
    private string $endDatePassed;

    public function __construct()
    {
        $this->startDate = date('Y/m/d H:i:s', time());
        $this->endDate = date('Y/m/d H:i:s', time());
    }

    /**
     * set data to start stats
     * @param string $date
     * 
     * @return self
     */
    public function setDateStart(string $date): self
    {
        $this->startDate = $date;

        $passedDateTime = new DateTime($date);
        $passedDateTime = $passedDateTime->modify('-1 month');
        $this->startDatePassed = $passedDateTime->format('Y-m-d H:i:s');

        return $this;
    }

    /**
     * set data to start stats
     * @param string $date
     * 
     * @return self
     */
    public function setDateEnd(string $date): self
    {
        $this->endDate = $date;

        $passedDateTime = new DateTime($date);
        $passedDateTime = $passedDateTime->modify('-1 month');
        $this->endDatePassed = $passedDateTime->format('Y-m-d H:i:s');

        return $this;
    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return JsonResponse
     */
    public function incoming(bool $planning): JsonResponse
    {
        $entry = new IncomingService();
        $entry->setDateStart($this->startDate)->setDateEnd($this->endDate);

        $entryOld = new IncomingService();
        $entryOld->setDateStart($this->startDatePassed)->setDateEnd($this->endDatePassed);

        if ($planning === true) {
            $entry->setPlanning($planning);
            $entryOld->setPlanning($planning);
        } else {
            $entry->setPlanning(false);
        }

        return response()->json(
            new ResponseService(
                $this->buildResponse($entry->get(), $entryOld->get())
            )
        );
    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return JsonResponse
     */
    public function expenses(bool $planning): JsonResponse
    {
        $entry = new ExpensesService();
        $entry->setDateStart($this->startDate)->setDateEnd($this->endDate);

        $entryOld = new ExpensesService();
        $entryOld->setDateStart($this->startDatePassed)->setDateEnd($this->endDatePassed);

        if ($planning === true) {
            $entry->setPlanning($planning);
            $entryOld->setPlanning($planning);
        } else {
            $entry->setPlanning(false);
        }

        return response()->json(
            new ResponseService(
                $this->buildResponse($entry->get(), $entryOld->get())
            )
        );
    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return JsonResponse
     */
    public function transfer(bool $planning): JsonResponse
    {
        $entry = new TransferService();
        $entry->setDateStart($this->startDate)->setDateEnd($this->endDate);

        $entryOld = new TransferService();
        $entryOld->setDateStart($this->startDatePassed)->setDateEnd($this->endDatePassed);

        if ($planning === true) {
            $entry->setPlanning($planning);
            $entryOld->setPlanning($planning);
        } else {
            $entry->setPlanning(false);
        }

        return response()->json(
            new ResponseService(
                $this->buildResponse($entry->get(), $entryOld->get())
            )
        );
    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return JsonResponse
     */
    public function debit(bool $planning): JsonResponse
    {
        $entry = new DebitService();
        $entry->setDateStart($this->startDate)->setDateEnd($this->endDate);

        $entryOld = new DebitService();
        $entryOld->setDateStart($this->startDatePassed)->setDateEnd($this->endDatePassed);

        if ($planning === true) {
            $entry->setPlanning($planning);
            $entryOld->setPlanning($planning);
        } else {
            $entry->setPlanning(false);
        }

        return response()->json(
            new ResponseService(
                $this->buildResponse($entry->get(), $entryOld->get())
            )
        );
    }

    /**
     * retrive total wallet sum
     */
    public function total(bool $planning): JsonResponse
    {
        $lastRow = $this->getActionConfigurations(0);

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->modify('Last day of this month');
        $dateTime = $dateTime->format('Y-m-d H:i:s');

        $entry = new EntryService();
        $entry->addConditions('id', '>', $lastRow->lastrow);
        $entry->addConditions('installment', 0);

        $entry->setPlanning(false);

        $total = MathHelper::sum($entry->get()) + $lastRow->amount;

        if ($planning === true) {
            $plannedEntry = MathHelper::sum($this->getPlannedEntry());
            $total += $plannedEntry;
        }

        return response()->json(
            new ResponseService(
                [
                    'total' => $total,
                ]
            )
        );
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

        //TODO: use a service
        $entry = Entry::where('planned', 1)->where('date_time', '<=', $dateTime)
            ->where('date_time', '>=', $dateTimeFirst)
            ->where('installment', 0)->get();

        return $entry;
    }

    /** 
     * retrive all accounts
     */
    public function wallets(bool $planning): JsonResponse
    {
        $accounts = Account::all();
        $response = [];
        foreach ($accounts as $account) {
            $lastRow = $this->getActionConfigurations($account->id);

            $entry = new EntryService();
            $entry->addConditions('account_id', $account->id);
            $entry->addConditions('id', '>', $lastRow->lastrow);

            if ($planning === true) {
                $entry->setPlanning($planning);
            } else {
                $entry->setPlanning(false);
            }

            $mathTotal = new EntriesMath();
            $mathTotal->setData($entry->get());

            $response[] = [
                'account_id' => $account->id,
                'account_label' => $account->name,
                'color' => $account->color,
                'total_wallet' => round($mathTotal->sum() + $lastRow->amount, 2)
            ];
        }


        return response()->json(new ResponseService(
            $response
        ));
    }

    /**
     * build stats standard response
     * @param \Illuminate\Database\Eloquent\Collection|\App\BudgetTracker\Models\Entry $data
     * @param \Illuminate\Database\Eloquent\Collection|\App\BudgetTracker\Models\Entry $dataOld
     * 
     * @return array
     */
    private function buildResponse(\Illuminate\Database\Eloquent\Collection|\App\BudgetTracker\Models\Entry $data, \Illuminate\Database\Eloquent\Collection|\App\BudgetTracker\Models\Entry $dataOld)
    {
        $mathTotal = new EntriesMath();
        $mathTotal->setData($data);

        $mathTotalPassed = new EntriesMath();
        $mathTotalPassed->setData($dataOld);

        $firstValue = $mathTotal->sum();
        $secondValue = $mathTotalPassed->sum();

        return [
            'total' => round($firstValue, 2),
            'total_passed' => $secondValue,
            'percentage' => MathHelper::percentage($firstValue, $secondValue)
        ];
    }

    /**
     * get wallet fix 78187.79;
     * @param int $account_id 
     * @return \stdClass
     */
    private function getActionConfigurations(int $account_id): \stdClass
    {
        $fix = ActionJobConfiguration::where("action", Action::Configurations->value)->orderBy("id", "desc")->get('config');
        $config = json_decode(
            '{"account_id":' . $account_id . ',"amount":"0","lastrow":1}'
        );
        foreach ($fix as $f) {
            $config = json_decode($f->config);
            if ($config->account_id == $account_id) {
                return $config;
            }
        }

        return $config;
    }

    /**
     * get the healt of wallet
     */
    public function health(bool $planned): JsonResponse
    {
        $lastRow = $this->getActionConfigurations(0);

        $dateTime = new DateTime('now');
        $dateTime = $dateTime->modify('Last day of this month');
        $dateTime = $dateTime->format('Y-m-d H:i:s');

        $entry = new EntryService();
        $entry->addConditions('id', '>', $lastRow->lastrow);
        $entry->setPlanning(false);

        $total = MathHelper::sum($entry->get()) + $lastRow->amount;

        $plannedEntry = MathHelper::sum($this->getPlannedEntry());
        $total += $plannedEntry;

        return response()->json(
            new ResponseService(
                [
                    'total' => $total,
                ]
            )
        );
    }
}

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
use App\Helpers\EntriesMath;
use App\Helpers\MathHelper;
use DateTime;
use \Illuminate\Http\JsonResponse;
use App\Stats\Services\StatsService;

class StatsController extends Controller
{

    private string $startDate;
    private string $endDate;
    private string $startDatePassed;
    private string $endDatePassed;

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return JsonResponse
     */
    public function incoming(bool $planning): JsonResponse
    {
        $service = new StatsService();
        list($total, $totalPassed) = $service->incoming($planning);

        return response()->json(
            new ResponseService(
                $this->buildResponse($total, $totalPassed)
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
        $service = new StatsService();
        list($total, $totalPassed) = $service->expenses($planning);

        return response()->json(
            new ResponseService(
                $this->buildResponse($total, $totalPassed)
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
        $service = new StatsService();
        list($total, $totalPassed) = $service->transfer($planning);

        return response()->json(
            new ResponseService(
                $this->buildResponse($total, $totalPassed)
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
        $service = new StatsService();
        list($total, $totalPassed) = $service->debit($planning);

        return response()->json(
            new ResponseService(
                $this->buildResponse($total, $totalPassed)
            )
        );
    }

    /**
     * retrive total wallet sum
     */
    public function total(bool $planning): JsonResponse
    {
        $service = new StatsService();

        return response()->json(
            new ResponseService(
                [
                    'total' => $service->total($planning),
                ]
            )
        );
    }

    /** 
     * retrive all accounts
     */
    public function wallets(bool $planning): JsonResponse
    {
        $service = new StatsService();

        return response()->json(new ResponseService(
            $service->wallets($planning, Account::all())
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
     * get the healt of wallet
     */
    public function health(bool $planned): JsonResponse
    {
        $service = new StatsService();

        return response()->json(
            new ResponseService(
                [
                    'total' => $service->health($planned),
                ]
            )
        );
    }
}

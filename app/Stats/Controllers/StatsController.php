<?php

namespace App\Stats\Controllers;

use App\BudgetTracker\Entity\Wallet;
use App\BudgetTracker\Http\Controllers\Controller;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Services\ResponseService;
use App\Helpers\EntriesMath;
use \Illuminate\Http\JsonResponse;
use App\Stats\Services\StatsService;
use DateTime;

class StatsController extends Controller
{
    private readonly string $startDate;
    private readonly string $endDate;


    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * retrive data
     * @param bool $planning
     * 
     * @return JsonResponse
     */
    public function incoming(bool $planning): JsonResponse
    {
        $service = new StatsService($this->startDate, $this->endDate);
        $result = $service->incoming($planning);

        return response()->json(
            new ResponseService(
                $result
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
        $service = new StatsService($this->startDate, $this->endDate);
        $result = $service->expenses($planning);

        return response()->json(
            new ResponseService(
                $result
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
        $service = new StatsService($this->startDate, $this->endDate);
        $result = $service->transfer($planning);

        return response()->json(
            new ResponseService(
                $result
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
        $service = new StatsService($this->startDate, $this->endDate);
        $result = $service->debit($planning);

        return response()->json(
            new ResponseService(
                $result
            )
        );
    }

    /**
     * retrive total wallet sum
     */
    public function total(bool $planning): JsonResponse
    {
        $service = new StatsService($this->startDate, $this->endDate);

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
    public function wallets(): JsonResponse
    {
        $service = new StatsService($this->startDate, $this->endDate);

        return response()->json(new ResponseService(
            $service->wallets(Account::user()->get())
        ));
    }

    /**
     * get the healt of wallet
     */
    public function health(bool $planned): JsonResponse
    {
        $service = new StatsService($this->startDate, $this->endDate);

        return response()->json(
            new ResponseService(
                [
                    'total' => $service->health($planned),
                ]
            )
        );
    }
}

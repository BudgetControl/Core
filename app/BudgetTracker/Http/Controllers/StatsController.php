<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use App\BudgetTracker\Services\DebitService;
use App\BudgetTracker\Services\ExpensesService;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Services\IncomingService;
use App\BudgetTracker\Services\TransferService;
use App\BudgetTracker\Services\Math\EntriesMath;
use Database\Seeders\TransferSeed;
use DateTime;
use \Illuminate\Http\JsonResponse;

class StatsController extends Controller
{

    private string $startDate;
    private string $endDate;

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
        $entry->setPlanning($planning)->setDateStart($this->startDate)->setDateEnd($this->endDate);
        return response()->json(new ResponseService(
            $this->buildResponse($entry->get()))
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
        $entry->setPlanning($planning)->setDateStart($this->startDate)->setDateEnd($this->endDate);
        return response()->json(new ResponseService(
            $this->buildResponse($entry->get()))
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
        $entry->setPlanning($planning)->setDateStart($this->startDate)->setDateEnd($this->endDate);
        return response()->json(new ResponseService(
            $this->buildResponse($entry->get()))
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
        $entry->setPlanning($planning)->setDateStart($this->startDate)->setDateEnd($this->endDate);
        return response()->json(new ResponseService(
            $this->buildResponse($entry->get()))
        );
        
    }

    /**
     * build stats standard response
     * @param \Illuminate\Database\Eloquent\Collection|\App\BudgetTracker\Models\Entry $data
     * 
     * @return array
     */
    private function buildResponse(\Illuminate\Database\Eloquent\Collection|\App\BudgetTracker\Models\Entry $data)
    {
        $mathTotal = new EntriesMath();
        $mathTotal->setData($data);

        return [
            'total' => $mathTotal->sum()
        ];
    }

}

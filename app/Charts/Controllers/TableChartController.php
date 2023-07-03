<?php

namespace App\Charts\Controllers;

use App\BudgetTracker\Enums\EntryType;
use App\Charts\Services\BarChartService;
use Illuminate\Http\JsonResponse;
use App\Charts\Services\LineChartService;
use App\Charts\Services\TableChartService;
use League\Config\Exception\ValidationException;
use Nette\Schema\ValidationException as NetteException;
use Illuminate\Http\Request;

class TableChartController
{

    /**
     * get line chart data
     * @param Request $data
     * 
     * @return JsonResponse
     */

    public function expensesByCategory(Request $data): JsonResponse
    {
        $results = new \stdClass();
        $dateTime = $data->date_time;
        $this->validate($dateTime);

        $service = new TableChartService($dateTime);
        $chart = $service->expensesByCategory();
        $rows = $chart->getRows();

        foreach ($rows as $row) {
            $results->series[] = [
                'value' => $row->getAmount(),
                'value_previus' => $row->getPrevAmount(),
                'label' => $row->getLabel(),
                'bounce_rate' => $row->getBounceRate()
            ];
        }

        return response()->json($results);
    }


    /**
     * get line chart data
     * @param Request $data
     * 
     * @return JsonResponse
     */

    public function expensesByLabel(Request $data): JsonResponse
    {
        $results = new \stdClass();
        $dateTime = $data->date_time;
        $this->validate($dateTime);

        $service = new TableChartService($dateTime);
        $chart = $service->expensesByLabel();
        $rows = $chart->getRows();

        foreach ($rows as $row) {
            $results->series[] = [
                'value' => $row->getAmount(),
                'value_previus' => $row->getPrevAmount(),
                'label' => $row->getLabel(),
                'bounce_rate' => $row->getBounceRate()
            ];
        }

        return response()->json($results);
    }

    /**
     * get line chart data
     * @param Request $data
     * 
     * @return JsonResponse
     */

    public function incomingByLabel(Request $data): JsonResponse
    {
        $results = new \stdClass();
        $dateTime = $data->date_time;
        $this->validate($dateTime);

        $service = new TableChartService($dateTime);
        $chart = $service->incomingByLabel();
        $rows = $chart->getRows();

        foreach ($rows as $row) {
            $results->series[] = [
                'value' => $row->getAmount(),
                'value_previus' => $row->getPrevAmount(),
                'label' => $row->getLabel(),
                'bounce_rate' => $row->getBounceRate()
            ];
        }

        return response()->json($results);
    }

    /**
     * validate data
     * 
     * @return void
     */
    private function validate(array $data): void
    {

        if (!is_array($data)) {
            throw new ValidationException(
                new NetteException('date time must be an erray')
            );
        }

        foreach ($data as $e) {
            if (!array_key_exists('start', $e) || !array_key_exists('end', $e)) {
                throw new ValidationException(
                    new NetteException('date time must be have start and end keys')
                );
            }
        }
    }
}

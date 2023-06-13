<?php

namespace App\Charts\Controllers;

use App\Charts\Services\BarChartService;
use Illuminate\Http\JsonResponse;
use App\Charts\Services\LineChartService;
use League\Config\Exception\ValidationException;
use Nette\Schema\ValidationException as NetteException;
use Illuminate\Http\Request;

class BarChartController
{

    /**
     * get line chart data
     * @param Request $data
     * 
     * @return JsonResponse
     */

    public function incomingYear(Request $data): JsonResponse
    {
        $results = new \stdClass();
        $dateTime = $data->date_time;
        $this->validate($dateTime);

        $service = new BarChartService($dateTime);
        $chart = $service->expensesByCategory();
        $bars = $chart->getBars();

        foreach ($bars as $bar) {
            $results->series[] = [
                'label' => $bar->getLabel(),
                'bar' => $bar->getValue(),
                'color' => $bar->getColor()
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

    public function incomingMonth(Request $data): JsonResponse
    {
        $results = new \stdClass();
        $dateTime = $data->date_time;
        $this->validate($dateTime);

        $service = new BarChartService($dateTime);
        $chart = $service->expensesByCategory();
        $bars = $chart->getBars();

        foreach ($bars as $bar) {
            $results->series[] = [
                'label' => $bar->getLabel(),
                'bar' => $bar->getValue(),
                'color' => $bar->getColor()
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

    public function expensesByCategory(Request $data): JsonResponse
    {
        $results = new \stdClass();
        $dateTime = $data->date_time;
        $this->validate($dateTime);

        $service = new BarChartService($dateTime);
        $chart = $service->expensesByCategory();
        $bars = $chart->getBars();

        foreach ($bars as $bar) {
            $results->series[] = [
                'label' => $bar->getLabel(),
                'bar' => $bar->getValue(),
                'color' => $bar->getColor()
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

        $service = new BarChartService($dateTime);
        $chart = $service->expensesByLabel();
        $bars = $chart->getBars();

        foreach ($bars as $bar) {
            $results->series[] = [
                'label' => $bar->getLabel(),
                'bar' => $bar->getValue(),
                'color' => $bar->getColor()
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

        $service = new BarChartService($dateTime);
        $chart = $service->incomingByLabel();
        $bars = $chart->getBars();

        foreach ($bars as $bar) {
            $results->series[] = [
                'label' => $bar->getLabel(),
                'bar' => $bar->getValue(),
                'color' => $bar->getColor()
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

<?php

namespace App\Charts\Controllers;

use Illuminate\Http\JsonResponse;
use App\Charts\Services\LineChartService;
use League\Config\Exception\ValidationException;
use Nette\Schema\ValidationException as NetteException;
use Illuminate\Http\Request;

class LineChartController
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

        $service = new LineChartService($dateTime);
        $chart = $service->incomingDate();
        $series = $chart->getSeries();

        foreach ($series as $serie) {
            $points = $serie->getDataPoints();
            $results->series[] = [
                'label' => $serie->getLabel(),
                'points' => [
                    'x' => $points->getXValue(),
                    'y' => $points->getYValue()
                ]
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

        $service = new LineChartService($dateTime);
        $chart = $service->incomingDate();
        $series = $chart->getSeries();

        foreach ($series as $serie) {
            $points = $serie->getDataPoints();
            $results->series[] = [
                'label' => $serie->getLabel(),
                'points' => [
                    'x' => $points->getXValue(),
                    'y' => $points->getYValue()
                ]
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

        $service = new LineChartService($dateTime);
        $chart = $service->expensesByCategory();
        $series = $chart->getSeries();

        foreach ($series as $serie) {
            $points = $serie->getDataPoints();
            $results->series[] = [
                'label' => $serie->getLabel(),
                'points' => [
                    'x' => $points->getXValue(),
                    'y' => $points->getYValue()
                ]
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

    public function incomingByCategory(Request $data): JsonResponse
    {
        $results = new \stdClass();
        $dateTime = $data->date_time;
        $this->validate($dateTime);

        $service = new LineChartService($dateTime);
        $chart = $service->incomingByCategory();
        $series = $chart->getSeries();

        foreach ($series as $serie) {
            $points = $serie->getDataPoints();
            $results->series[] = [
                'label' => $serie->getLabel(),
                'color' => $serie->getColor(),
                'points' => [
                    'x' => $points->getXValue(),
                    'y' => $points->getYValue()
                ]
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
 
         $service = new LineChartService($dateTime);
         $chart = $service->expensesByLabel();
         $series = $chart->getSeries();
 
         foreach ($series as $serie) {
             $points = $serie->getDataPoints();
             $results->series[] = [
                 'label' => $serie->getLabel(),
                 'points' => [
                     'x' => $points->getXValue(),
                     'y' => $points->getYValue()
                 ]
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

        $service = new LineChartService($dateTime);
        $chart = $service->incomingByLabel();
        $series = $chart->getSeries();

        foreach ($series as $serie) {
            $points = $serie->getDataPoints();
            $results->series[] = [
                'label' => $serie->getLabel(),
                'points' => [
                    'x' => $points->getXValue(),
                    'y' => $points->getYValue()
                ]
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

<?php

namespace App\Charts\Services;

use App\BudgetTracker\Entity\Wallet;
use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\SubCategory;
use App\Charts\Entity\LineChart\LineChart;
use App\Charts\Entity\LineChart\LineChartPoint;
use App\Charts\Entity\LineChart\LineChartSeries;
use DateTime;

class LineChartService extends ChartDataService
{
    const Y_VALUE = 5000.00;
    private array $dateTime;

    /**
     * @param array dateTime [start => '', end => '']
     */
    public function __construct(array $dateTime)
    {
        foreach ($dateTime as $date) {
            $this->dateTime[] = [
                'start' => new DateTime($date['start']),
                'end' => new DateTime($date['end']),
            ];
        }
    }

    /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return LineChart
     */

     public function incomingDate(): LineChart
     {
         $chart = new LineChart();
 
         foreach ($this->dateTime as $date) {
             $data = $this->incoming($date['start'], $date['end']);
 
             if (!empty($data)) {
                 $wallet = new Wallet();
                 $wallet->sum($data);
                 $serie = new LineChartSeries($date['start']->format('Y-m-d'));
                 $serie->addDataPoint(new LineChartPoint($wallet->getBalance(), self::Y_VALUE));
                 $chart->addSeries($serie);
             }
         }
 
         return $chart;
     }

    /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return LineChart
     */

    public function incomingByCategory(): LineChart
    {
        $chart = new LineChart();
        $categories = SubCategory::all();

        foreach ($this->dateTime as $date) {
            foreach($categories as $category) {
                $data = $this->incomingCategory($date['start'], $date['end'], $category->id);
                if (!empty($data)) {
                    $wallet = new Wallet();
                    $wallet->sum($data);
                    $serie = new LineChartSeries($category->name);
                    $serie->addDataPoint(new LineChartPoint($wallet->getBalance(), self::Y_VALUE));
                    $chart->addSeries($serie);
                }
            }
        }

        return $chart;
    }

    /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return LineChart
     */

     public function incomingByLabel(): LineChart
     {
         $chart = new LineChart();
         $labels = Labels::user()->get();
 
         foreach ($this->dateTime as $date) {
             foreach($labels as $label) {
                 $data = $this->incomingLabel($date['start'], $date['end'], $label->id);
 
                 if (!empty($data)) {
                     $wallet = new Wallet();
                     $wallet->sum($data);
                     $serie = new LineChartSeries($label->name);
                     $serie->addDataPoint(new LineChartPoint($wallet->getBalance(), self::Y_VALUE));
                     $chart->addSeries($serie);
                 }
             }
         }
 
         return $chart;
     }

     /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return LineChart
     */

    public function expensesDate(): LineChart
    {
        $chart = new LineChart();

        foreach ($this->dateTime as $date) {
            $data = $this->expenses($date['start'], $date['end']);

            if (!empty($data)) {
                $wallet = new Wallet();
                $wallet->sum($data);
                $serie = new LineChartSeries($date['start']->format('Y-m-d'));
                $serie->addDataPoint(new LineChartPoint($wallet->getBalance(), self::Y_VALUE));
                $chart->addSeries($serie);
            }
        }

        return $chart;
    }

        /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return LineChart
     */

     public function expensesByCategory(): LineChart
     {
         $chart = new LineChart();
         $categories = SubCategory::all();
 
         foreach ($this->dateTime as $date) {
             foreach($categories as $category) {
                 $data = $this->expensesCategory($date['start'], $date['end'], $category->id);
 
                 if (!empty($data)) {
                     $wallet = new Wallet();
                     $wallet->sum($data);
                     $serie = new LineChartSeries($category->name);
                     $serie->addDataPoint(new LineChartPoint($wallet->getBalance(), self::Y_VALUE));
                     $chart->addSeries($serie);
                 }
             }
         }
 
         return $chart;
     }

    /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return LineChart
     */

     public function expensesByLabel(): LineChart
     {
         $chart = new LineChart();
         $labels = Labels::user()->get();
 
         foreach ($this->dateTime as $date) {
             foreach($labels as $label) {
                 $data = $this->expensesLabel($date['start'], $date['end'], $label->id);
 
                 if (!empty($data)) {
                     $wallet = new Wallet();
                     $wallet->sum($data);
                     $serie = new LineChartSeries($label->name);
                     $serie->addDataPoint(new LineChartPoint($wallet->getBalance(), self::Y_VALUE));
                     $chart->addSeries($serie);
                 }
             }
         }
 
         return $chart;
     }

}

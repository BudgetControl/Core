<?php

namespace App\Charts\Services;

use App\BudgetTracker\Entity\Wallet;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\SubCategory;
use App\Charts\Entity\BarChart\BarChart;
use App\Charts\Entity\BarChart\BarChartBar;
use DateTime;

class BarChartService extends ChartDataService
{

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
     * @return BarChart
     */

    public function incomingDate(): BarChart
    {
        $chart = new BarChart();

        foreach ($this->dateTime as $date) {
            $data = $this->incoming($date['start'], $date['end']);

            if (!empty($data)) {
                $wallet = new Wallet();
                $wallet->sum($data);
                $bar = new BarChartBar($wallet->getBalance(), $date['start']->format('Y-m-d'));
                $chart->addBar($bar);
            }
        }

        return $chart;
    }

    /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return BarChart
     */

    public function incomingByCategory(): BarChart
    {
        $chart = new BarChart();
        $categories = SubCategory::all();

        foreach ($this->dateTime as $date) {
            foreach ($categories as $category) {
                $data = $this->incomingCategory($date['start'], $date['end'], $category->id);
                if (!empty($data)) {
                    $wallet = new Wallet();
                    $wallet->sum($data);
                    $bar = new BarChartBar($wallet->getBalance(), $category->name);
                    $chart->addBar($bar);
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
     * @return BarChart
     */

    public function incomingByLabel(): BarChart
    {
        $chart = new BarChart();
        $labels = Labels::user()->get();

        foreach ($this->dateTime as $date) {
            foreach ($labels as $label) {
                $data = $this->incomingLabel($date['start'], $date['end'], $label->id);

                if (!empty($data)) {
                    $wallet = new Wallet();
                    $wallet->sum($data);
                    $bar = new BarChartBar($wallet->getBalance(), $label->name);
                    $chart->addBar($bar);
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
     * @return BarChart
     */

    public function expensesDate(): BarChart
    {
        $chart = new BarChart();

        foreach ($this->dateTime as $date) {
            $data = $this->expenses($date['start'], $date['end']);

            if (!empty($data)) {
                $wallet = new Wallet();
                $wallet->sum($data);
                $bar = new BarChartBar($wallet->getBalance(), $date['start']->format('Y-m-d'));
                $chart->addBar($bar);
            }
        }

        return $chart;
    }

    /**
     * get line chart data
     * @param string $year the start year
     * @param string $toYear the last year
     * 
     * @return BarChart
     */

    public function expensesByCategory(): BarChart
    {
        $chart = new BarChart();
        $categories = SubCategory::all();

        foreach ($this->dateTime as $date) {
            foreach ($categories as $category) {
                $data = $this->expensesCategory($date['start'], $date['end'], $category->id);

                if (!empty($data)) {
                    $wallet = new Wallet();
                    $wallet->sum($data);
                    $bar = new BarChartBar($wallet->getBalance(), $category->name);
                    $chart->addBar($bar);
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
     * @return BarChart
     */

    public function expensesByLabel(): BarChart
    {
        $chart = new BarChart();
        $labels = Labels::user()->get();

        foreach ($this->dateTime as $date) {
            foreach ($labels as $label) {
                $data = $this->expensesLabel($date['start'], $date['end'], $label->id);

                if (!empty($data)) {
                    $wallet = new Wallet();
                    $wallet->sum($data);
                    $bar = new BarChartBar($wallet->getBalance(), $label->name);
                    $chart->addBar($bar);
                }
            }
        }

        return $chart;
    }
}

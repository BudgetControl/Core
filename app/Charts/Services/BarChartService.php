<?php

namespace App\Charts\Services;

use DateTime;
use App\BudgetTracker\Entity\Wallet;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Category;
use App\Charts\Entity\BarChart\BarChart;
use App\BudgetTracker\Models\SubCategory;
use App\Charts\Services\ChartDataService;
use App\Charts\Entity\BarChart\BarChartBar;

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
                $bar = new BarChartBar($data['total'], $date['start']->format('Y-m-d'));
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
        $categories =  Category::getCateroyGroup("incoming");

        foreach ($this->dateTime as $date) {
            foreach ($categories as $category) {
                $data = $this->incomingCategory($date['start'], $date['end'], $category->id);
                if (!empty($data)) {
                    $bar = new BarChartBar($data['total'], $category->name);
                    $chart->addBar($bar);
                }
            }
        }

        return $chart;
    }

    /**
     * get line chart data
     * @param array $types
     * 
     * @return BarChart
     */

    public function dataByTypes(array $types): BarChart
    {
        $chart = new BarChart();

        foreach ($this->dateTime as $date) {
            foreach ($types as $type) {

                switch ($type) {
                    case EntryType::Incoming->value:
                        $data = $this->incoming($date['start'], $date['end']);
                        break;
                    case EntryType::Expenses->value:
                        $data = $this->expenses($date['start'], $date['end']);
                        break;
                    default:
                        throw new \Exception("Type of entry is not specified");
                }

                if (!empty($data)) {
                    $bar = new BarChartBar($data['total'], $type);
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
        $labels = Labels::where("archive",0)->orderBy("name")->get();

        foreach ($this->dateTime as $date) {
            foreach ($labels as $label) {
                $data = $this->incomingLabel($date['start'], $date['end'], $label->id);

                if (!empty($data)) {
                    $bar = new BarChartBar($data['total'], $label->name);
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
                $bar = new BarChartBar($data['total'], $date['start']->format('Y-m-d'));
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
        $categories =  Category::getCateroyGroup("expenses");

        foreach ($this->dateTime as $date) {
            foreach ($categories as $category) {
                $data = $this->expensesCategory($date['start'], $date['end'], $category->id);

                if (!empty($data)) {
                    $bar = new BarChartBar($data['total'], $category->name);
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
        $labels = Labels::where("archive",0)->orderBy("name")->get();

        foreach ($this->dateTime as $date) {
            foreach ($labels as $label) {
                $data = $this->expensesLabel($date['start'], $date['end'], $label->id);

                if (!empty($data)) {
                    $bar = new BarChartBar($data['total'], $label->name);
                    $chart->addBar($bar);
                }
            }
        }

        return $chart;
    }
}

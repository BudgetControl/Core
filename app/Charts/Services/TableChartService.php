<?php

namespace App\Charts\Services;

use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\SubCategory;
use App\Charts\Entity\TableChart\TableChart;
use App\Charts\Entity\TableChart\TableRowChart;
use App\Charts\Services\ChartDataService;
use DateTime;

class TableChartService extends ChartDataService
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
     * @return TableChart
     */

    public function incomingByCategory(): TableChart
    {
        $chart = new TableChart();
        $categories = SubCategory::where("exclude_from_stats",0)->orderBy("name")->get();
        ksort($this->dateTime);

        foreach ($this->dateTime as $date) {
            foreach ($categories as $category) {
                $data = $this->incomingCategory($date['start'], $date['end'], $category->id);

                if (!empty($data['total']) || !empty($data['total_passed'])) {
                    $row = new TableRowChart($data['total'], $data['total_passed'], $category->name);
                    $chart->addRows($row);
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
     * @return TableChart
     */

    public function incomingByLabel(): TableChart
    {
        $chart = new TableChart();
        $labels = Labels::where("archive",0)->orderBy("name")->get();
        ksort($this->dateTime);

        foreach ($this->dateTime as $date) {
            foreach ($labels as $label) {
                $data = $this->incomingLabel($date['start'], $date['end'], $label->id);

                if (!empty($data['total']) || !empty($data['total_passed'])) {
                    $row = new TableRowChart($data['total'], $data['total_passed'], $label->name);
                    $chart->addRows($row);
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
     * @return TableChart
     */

    public function expensesByCategory(): TableChart
    {
        $chart = new TableChart();
        $categories = SubCategory::where("exclude_from_stats",0)->orderBy("name")->get();

        foreach ($this->dateTime as $date) {
            foreach ($categories as $category) {

                $data = $this->expensesCategory($date['start'], $date['end'], $category->id);

                if (!empty($data['total']) || !empty($data['total_passed'])) {
                    $row = new TableRowChart($data['total'], $data['total_passed'], $category->name);
                    $chart->addRows($row);
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
     * @return TableChart
     */

    public function expensesByLabel(): TableChart
    {
        $chart = new TableChart();
        $labels = Labels::where("archive",0)->orderBy("name")->get();
        ksort($this->dateTime);

        foreach ($this->dateTime as $date) {
            foreach ($labels as $label) {

                $data = $this->expensesLabel($date['start'], $date['end'], $label->id);

                if (!empty($data['total']) || !empty($data['total_passed'])) {
                    $row = new TableRowChart($data['total'], $data['total_passed'], $label->name);
                    $chart->addRows($row);
                }
            }
        }

        return $chart;
    }
}

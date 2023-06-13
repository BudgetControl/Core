<?php
namespace App\Charts\Entity\LineChart;

use App\Charts\Entity\LineChart\LineChartSeries;

final class LineChart
{
    private $series = [];

    public function addSeries(LineChartSeries $series)
    {
        $this->series[] = $series;
    }

    public function getSeries()
    {
        return $this->series;
    }

   
}
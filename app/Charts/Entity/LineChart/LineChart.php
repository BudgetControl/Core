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

    private function hash(): string
    {       
        $hash = '';
        foreach($this->series as $serie) {
            $points = $serie->getDataPoints();
            $hash .= "{".$serie->getLabel().$serie->getColor().$points->getXValue().$points->getYValue()."}";
        }
        return md5("LineChart:$hash");
    }

    public function isEqualsTo(LineChart $chart): bool
    {
        return $this->hash() === $chart->hash();
    }

   
}
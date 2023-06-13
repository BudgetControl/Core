<?php
namespace App\Charts\Entity\LineChart;

use App\Charts\Entity\LineChart\LineChartPoint;

final class LineChartSeries
{
    private string $label;
    private string $color;
    private LineChartPoint $dataPoints;

    public function __construct($label)
    {
        $this->label = $label;
        $this->color = $this->color();
    }

    public function addDataPoint(LineChartPoint $dataPoint)
    {
        $this->dataPoints = $dataPoint;
    }

    public function getDataPoints(): LineChartPoint
    {
        return $this->dataPoints;
    }


    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    private function color()
    {
        $hex = '';
        for ($i = 0; $i < 6; $i++) {
            $hex .= dechex(mt_rand(0, 15));
        }
        return '#'.$hex;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }
}
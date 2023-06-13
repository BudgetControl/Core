<?php
namespace App\Charts\Entity\LineChart;

class LineChartPoint
{
    private int $xValue;
    private int $yValue;

    public function __construct(int $xValue, int $yValue)
    {
        $this->xValue = $xValue;
        $this->yValue = $yValue;
    }

    public function getXValue()
    {
        return $this->xValue;
    }

    public function getYValue()
    {
        return $this->yValue;
    }

    public function getXYValue()
    {
        return [$this->xValue,$this->yValue];
    }
}
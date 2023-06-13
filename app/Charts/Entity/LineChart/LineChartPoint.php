<?php
namespace App\Charts\Entity\LineChart;

class LineChartPoint
{
    private int $xValue;
    private int $yValue;
    private string $label;

    public function __construct(int $xValue, int $yValue, string $label = '')
    {
        $this->xValue = $xValue;
        $this->yValue = $yValue;
        $this->label = $label;
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
    
    public function getLabel()
    {
        return $this->label;
    }
}
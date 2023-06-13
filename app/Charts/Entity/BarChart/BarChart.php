<?php
namespace App\Charts\Entity\BarChart;

use App\Charts\Entity\BarChart\BarChartBar;

final class BarChart
{
    private array $bar;

    public function addBar(BarChartBar $bar)
    {
        $this->bar[] = $bar;
    }

    public function getBars()
    {
        return $this->bar;
    }

   
}
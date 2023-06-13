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

    private function hash(): string
    {       
        $hash = '';
        foreach($this->bar as $bar) {
            $hash .= "{".$bar->getLabel().$bar->getColor().$bar->getValue()."}";
        }
        return md5("BarChart:$hash");
    }

    public function isEqualsTo(BarChart $chart): bool
    {
        return $this->hash() === $chart->hash();
    }

   
}
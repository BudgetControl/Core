<?php
namespace App\Charts\Entity\BarChart;


final class BarChartBar
{
    private int $value;
    private string $label;
    private string $color;

    public function __construct(int $value, string $label)
    {
        $this->value = $value;
        $this->label = $label;
        $this->color = $this->color();
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
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }
}
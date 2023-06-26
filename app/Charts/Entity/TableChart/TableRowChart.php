<?php
namespace App\Charts\Entity\TableChart;
use DivisionByZeroError;

final class TableRowChart
{
    private float $amount;
    private float $prevAmount;
    private string $label;
    private int $bounceRate;

    public function __construct(int $amount, int $prevAmount, string $label)
    {
        $this->amount = $amount;
        $this->prevAmount = $prevAmount;
        $this->label = $label;
        $this->bounceRate = $this->bounceRate();
    }

    private function bounceRate()
    {
        try {
            $difference = abs($this->amount - $this->prevAmount);
            $segno = ($this->amount > $this->prevAmount) ? 1 : -1;
            $percentage = ($difference / $this->amount) * 100 * $segno;
        } catch(DivisionByZeroError $e) {
            $percentage = 0;
        }


        return $percentage;
    }

    /**
     * Get the value of amount
     */ 
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the value of prevAmount
     */ 
    public function getPrevAmount()
    {
        return $this->prevAmount;
    }

    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the value of bounceRate
     */ 
    public function getBounceRate()
    {
        return $this->bounceRate;
    }
}

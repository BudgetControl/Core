<?php
namespace App\Charts\Entity\TableChart;

use App\Charts\Entity\TableChart\TableRowChart;

final class TableChart
{
    private array $rows = [];

    public function addRows(TableRowChart $row)
    {
        $this->rows[] = $row;
    }

    public function getRows()
    {
        return $this->rows;
    }

    private function hash(): string
    {       
        $hash = '';
        foreach($this->rows as $row) {
            $hash .= "{".$row->getAmount().$row->getLabel().$row->getPrevAmount().$row->getBounceRate()."}";
        }
        return md5("BarChart:$hash");
    }

    public function isEqualsTo(TableChart $chart): bool
    {
        return $this->hash() === $chart->hash();
    }

   
}
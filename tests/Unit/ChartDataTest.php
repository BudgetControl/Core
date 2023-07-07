<?php

namespace Tests\Unit;

use App\Charts\Entity\BarChart\BarChart;
use App\Charts\Entity\BarChart\BarChartBar;
use Tests\TestCase;
use App\Charts\Entity\LineChart\LineChart;
use App\Charts\Entity\LineChart\LineChartPoint;
use App\Charts\Entity\LineChart\LineChartSeries;
use App\Charts\Entity\TableChart\TableChart;
use App\Charts\Entity\TableChart\TableRowChart;



class ChartDataTest extends TestCase
{
    const EXAMPLE_DATA = [
        [
            'label' => 'test',
            'value' => 100
        ],
        [
            'label' => 'test2',
            'value' => 200
        ],
        [
            'label' => 'test3',
            'value' => 300
        ]
        ];

    public function testLineChart()
    {

        $chart = new LineChart();
 
         foreach (self::EXAMPLE_DATA as $data) {
            $serie = new LineChartSeries($data['label']);
            $serie->addDataPoint(new LineChartPoint($data['value'], 1000));
            $chart->addSeries($serie);
         }
         
         $this->assertTrue($chart->isEqualsTo($chart));
 
    }

    public function testBarChart()
    {

        $chart = new BarChart();
 
         foreach (self::EXAMPLE_DATA as $data) {
            $bar = new BarChartBar($data['value'],$data['label']);
            $chart->addBar($bar);
         }
         
         $this->assertTrue($chart->isEqualsTo($chart));
 
    }

    public function testTableChart()
    {

        $chart = new TableChart();
 
         foreach (self::EXAMPLE_DATA as $data) {
            $bar = new TableRowChart($data['value'],200.00,'label');
            $chart->addRows($bar);
         }
         
         $this->assertTrue($chart->isEqualsTo($chart));
 
    }

}

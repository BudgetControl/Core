<?php

namespace Tests\Unit;

use App\BudgetTracker\Entity\DateTime;
use Tests\TestCase;

class DateTimeTest extends TestCase
{
    public function testWeek()
    {
        $dateTime = DateTime::week(1704730637);
        
        $startDate = $dateTime->startDate;
        $endDate = $dateTime->endDate;

        $this->assertTrue($startDate == '2024-01-08');
        $this->assertTrue($endDate == '2024-01-14');

    }

    public function testMonth()
    {
        $dateTime = DateTime::month(1704730637);
        
        $startDate = $dateTime->startDate;
        $endDate = $dateTime->endDate;

        $this->assertTrue($startDate == '2024-01-01');
        $this->assertTrue($endDate == '2024-01-31');

    }

    public function testYear()
    {
        $dateTime = DateTime::year(1704730637);
        
        $startDate = $dateTime->startDate;
        $endDate = $dateTime->endDate;

        $this->assertTrue($startDate == '2024-01-01');
        $this->assertTrue($endDate == '2024-12-31');

    }

}

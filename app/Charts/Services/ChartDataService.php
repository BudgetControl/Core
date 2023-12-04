<?php

namespace App\Charts\Services;

use DateTime;
use App\BudgetTracker\Models\Debit;
use Doctrine\DBAL\Driver\Exception;
use App\Stats\Services\StatsService;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Category;
use App\BudgetTracker\Models\Expenses;
use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Models\Transfer;
use App\Charts\Entity\LineChart\LineChart;

class ChartDataService
{

    /**
     * get line chart data
     * @param DateTime $start
     * @param DateTime $end
     * 
     * @return array
     */

    public function incoming(DateTime $start, DateTime $end): array
    {
        $stats = new StatsService($this->startDate($start),$this->endDate($end));
        return $stats->incoming(false);
    }

    /**
     * get line chart data
     * @param DateTime $start
     * @param DateTime $end
     * @param int $categoryId
     * 
     * @return array
     */

    public function incomingCategory(DateTime $start, DateTime $end, int $categoryId): array
    {
        $stats = new StatsService($this->startDate($start),$this->endDate($end));
        return $stats->entryByCategory([$categoryId],false);
    }

    /**
     * get line chart data
     * @param DateTime $start
     * @param DateTime $end
     * @param int $labelId
     * 
     * @return array
     */

    public function incomingLabel(DateTime $start, DateTime $end, int $labelId): array
    {
        $stats = new StatsService($this->startDate($start),$this->endDate($end));
        return $stats->entryByLabel([$labelId],false);
    }

    /**
     * get line chart data
     * @param DateTime $start
     * @param DateTime $end
     * 
     * @return array
     */

    public function expenses(DateTime $start, DateTime $end): array
    {
        $stats = new StatsService($this->startDate($start),$this->endDate($end));
        return $stats->expenses(false);
    }

    /**
     * get line chart data
     * @param DateTime $start
     * @param DateTime $end
     * @param int $categoryId
     * 
     * @return array
     */

    public function expensesCategory(DateTime $start, DateTime $end, int $categoryId): array
    {
        $stats = new StatsService($this->startDate($start),$this->endDate($end));
        return $stats->entryByCategory([$categoryId],false);
    }

    /**
     * get line chart data
     * @param DateTime $start
     * @param DateTime $end
     * @param int $labelId
     * 
     * @return array
     */

    public function expensesLabel(DateTime $start, DateTime $end, int $labelId): array
    {
        $stats = new StatsService($this->startDate($start),$this->endDate($end));
        return $stats->entryByLabel([$labelId],false);
    }

    /**
     * get line chart data
     * @param DateTime $start
     * @param DateTime $end
     * @param array $types type of data entry
     * 
     * @return array
     */

    public function types(DateTime $start, DateTime $end, array $types): array
    {
        $stats = new StatsService($this->startDate($start),$this->endDate($end));
        return $stats->entryByType([$types],false);
    }

    /**
     * set up date time to search
     * @param DateTime $date
     *
     * @return string
     */
    private function startDate(DateTime $date): string
    {
        return $date->format('Y-m-d');
    }

    private function endDate(DateTime $date): string
    {
        return $date->format('Y-m-d');
    }
}

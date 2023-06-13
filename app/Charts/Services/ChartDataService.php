<?php

namespace App\Charts\Services;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Debit;
use App\BudgetTracker\Models\Expenses;
use App\BudgetTracker\Models\Incoming;
use App\BudgetTracker\Models\Transfer;
use App\Charts\Entity\LineChart\LineChart;
use DateTime;

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
        return Incoming::user()->where('date_time', '>=', $this->startDate($start))
            ->where('date_time', '<=', $this->endDate($end))->where('type', EntryType::Incoming->value)->get()
            ->toArray();
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
         return Incoming::user()->where('date_time', '>=', $this->startDate($start))
             ->where('date_time', '<=', $this->endDate($end))->where('type', EntryType::Incoming->value)
             ->where('category_id',$categoryId)
             ->get()
             ->toArray();
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
         return Incoming::user()->where('date_time', '>=', $this->startDate($start))
             ->where('date_time', '<=', $this->endDate($end))->where('type', EntryType::Incoming->value)
             ->whereAs('labels',function($query) use($labelId) {
                $query->where('label', $labelId);
             })
             ->get()
             ->toArray();
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
        return Expenses::user()->where('date_time', '>=', $this->startDate($start))
            ->where('date_time', '<=', $this->endDate($end))->where('type', EntryType::Expenses->value)->get()
            ->toArray();
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
         return Expenses::user()->where('date_time', '>=', $this->startDate($start))
             ->where('date_time', '<=', $this->endDate($end))->where('type', EntryType::Expenses->value)
             ->where('category_id',$categoryId)
             ->get()
             ->toArray();
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
         return Expenses::user()->where('date_time', '>=', $this->startDate($start))
             ->where('date_time', '<=', $this->endDate($end))->where('type', EntryType::Expenses->value)
             ->whereHas('label',function($query) use($labelId) {
                $query->where('labels_id', $labelId);
             })
             ->get()
             ->toArray();
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

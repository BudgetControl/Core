<?php

namespace App\Charts\Services;

use DateTime;
use App\BudgetTracker\Models\Debit;
use Doctrine\DBAL\Driver\Exception;
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
        return Incoming::user()->where('date_time', '>=', $this->startDate($start))
            ->where('planned', 0)->where('confirmed', 1)
            ->where('date_time', '<=', $this->endDate($end))->whereIn('category_id', $this->getCategoryId(EntryType::Incoming->value))->get()
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
            ->where('date_time', '<=', $this->endDate($end))->whereIn('category_id', $this->getCategoryId(EntryType::Incoming->value))
            ->where('planned', 0)->where('confirmed', 1)
            ->where('category_id', $categoryId)
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
            ->where('date_time', '<=', $this->endDate($end))->whereIn('category_id', $this->getCategoryId(EntryType::Incoming->value))
            ->where('planned', 0)->where('confirmed', 1)
            ->whereAs('labels', function ($query) use ($labelId) {
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
            ->where('planned', 0)->where('confirmed', 1)
            ->where('date_time', '<=', $this->endDate($end))->whereIn('category_id', $this->getCategoryId(EntryType::Expenses->value))->get()
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
            ->where('date_time', '<=', $this->endDate($end))->whereIn('category_id', $this->getCategoryId(EntryType::Expenses->value))
            ->where('planned', 0)->where('confirmed', 1)
            ->where('category_id', $categoryId)
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
            ->where('date_time', '<=', $this->endDate($end))->whereIn('category_id', $this->getCategoryId(EntryType::Expenses->value))
            ->where('planned', 0)->where('confirmed', 1)
            ->whereHas('label', function ($query) use ($labelId) {
                $query->where('labels_id', $labelId);
            })
            ->get()
            ->toArray();
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
        return Incoming::user()->where('date_time', '>=', $this->startDate($start))
            ->where('date_time', '<=', $this->endDate($end))->whereIn('type', $types)
            ->where('planned', 0)->where('confirmed', 1)
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

    /**
     *  retrive only category id
     */
    private function getCategoryId(string $type): array
    {
        $results = [];
        $categories = Category::getCateroyGroup($type);
        foreach($categories as $cat) {
            $results[] = $cat->id;
        }

        if(empty($results)) {
            throw new Exception("Ops no category foud with type ( $type )", 500);
        }

        return $results;
    }
}

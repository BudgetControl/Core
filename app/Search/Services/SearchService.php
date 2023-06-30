<?php

namespace Search\Services;

use App\BudgetTracker\Entity\Entries\Entry;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Interfaces\EntryInterface;
use DateTime;
use Illuminate\Support\Collection;
use Search\Entity\Search;
use Search\Repository\EntryRepository;

class SearchService
{

    /** @var DateTime */
    private $dateTime;

    public function __construct(string $month, string $year)
    {
        $this->dateTime = new DateTime("$year-$month-01 00:00:00");
    }

    /**
     * find all data
     * @param array $filter {"account":[31],"category":[16],"type":["incoming"],"tags":[201],"text":"test","planned":"0","year":2022,"month":4}
     * 
     * @return array
     */
    public function find(array $filter): array
    {
        $repository = new EntryRepository();

        if (!empty($filter['account'])) {
            $repository->account($filter['account']);
        }

        if (!empty($filter['category'])) {
            $repository->category($filter['category']);
        }

        if (!empty($filter['label'])) {
            $repository->label($filter['label']);
        }

        if (!empty($filter['text'])) {
            $repository->note($filter['text']);
        }

        if (!empty($filter['planned'])) {
            $repository->planned($filter['planned']);
        }

        if (!empty($filter['confirmed'])) {
            $repository->confirmed($filter['confirmed']);
        }

        if (!empty($filter['type'])) {
            foreach ($filter['type'] as $type) {
                $repository->$type();
            }
        }

        $repository->dateTime($this->dateTime, '<=');

        $result = $repository->get();

        return [
            $this->makeIncomingObj($result),
            $this->makeExpensesObj($result),
            $this->makeTransferObj($result),
            $this->makeDebitObj($result)
        ];

    }

    private function makeIncomingObj(Collection $collections): Search
    {
        $entity = new Search();
        foreach($collections as $collection) {
            if($collection->type === EntryType::Incoming->value) {
                $entity->setEntry($collection);
            }
        }

        return $entity;
    }

    private function makeExpensesObj(Collection $collections): Search
    {
        $entity = new Search();
        foreach($collections as $collection) {
            if($collection->type === EntryType::Expenses->value) {
                $entity->setEntry($collection);
            }
        }

        return $entity;
    }

    private function makeTransferObj(Collection $collections): Search
    {
        $entity = new Search();
        foreach($collections as $collection) {
            if($collection->type === EntryType::Transfer->value) {
                $entity->setEntry($collection);
            }
        }

        return $entity;
    }

    private function makeDebitObj(Collection $collections): Search
    {
        $entity = new Search();
        foreach($collections as $collection) {
            if($collection->type === EntryType::Debit->value) {
                $entity->setEntry($collection);
            }
        }

        return $entity;
    }

}

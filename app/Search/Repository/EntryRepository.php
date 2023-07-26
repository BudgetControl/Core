<?php

namespace Search\Repository;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use DateTime;

class EntryRepository {

    const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var DB */
    protected $query;
    protected $type = [];

    public function __construct()
    {
        $this->query = Entry::withRelations()->orderBy('date_time','desc');
    }

    public function get(array $column = ['*']): Collection
    {
        $this->getType();
        return $this->query->get($column);
    }

    public function getById(array $ids,array $column = ['*']): Collection
    {
        $this->getType();
        return $this->query->whereIn('id',$ids)->get($column);
    }

    public function getByUuid(array $ids,array $column = ['*']): Collection
    {
        $this->getType();
        return $this->query->whereIn('uuid',$ids)->get($column);
    }

    public function incoming(): self
    {
        $this->type[] = EntryType::Incoming->value;
        return $this;
    }

    public function expenses(): self
    {
        $this->type[] = EntryType::Expenses->value;
        return $this;
    }

    public function transfer(): self
    {
        $this->type[] = EntryType::Transfer->value;
        return $this;
    }

    public function debit(): self
    {
        $this->type[] = EntryType::Debit->value;
        return $this;
    }

    public function note(string $text):self
    {
        $this->query->where('note','like', "%$text%");
        return $this;
    }

    public function dateTime(DateTime $dateStart, string $sign = ''): self
    {
        if(empty($sign)) {
            $this->query->where('date_time',$dateStart->format(self::DATE_FORMAT));
        } else {
            $this->query->where('date_time',$sign,$dateStart->format(self::DATE_FORMAT));
        }
        return $this;
    }

    public function dateTimeBetween(DateTime $dateStart, DateTime $dateEnd): self
    {
        $this->query->where('date_time','>=', $dateStart->format(self::DATE_FORMAT));
        $this->query->where('date_time','<=', $dateEnd->format(self::DATE_FORMAT));

        return $this;
    }

    public function account(array $ids): self
    {
        $this->query->whereIn('account_id',$ids);
        return $this;
    }

    public function category(array $ids): self
    {
        $this->query->whereIn('category_id',$ids);
        return $this;
    }

    public function payee(array $ids): self
    {
        $this->query->whereIn('payee_id',$ids);
        return $this;
    }

    public function label(array $ids): self
    {
        $this->query->whereHas('label',function(Builder $q) use($ids) {
            $q->whereIn('labels.id',$ids);
        });

        return $this;
    }

    public function confirmed(): self
    {
        $this->query->where('confirmed',1);
    }

    public function planned(): self
    {
        $this->query->where('planned',1);
    }

    public function waranty(): self
    {
        $this->query->where('waranty',1);
    }

    public static function getCategoryName(int $id): string
    {
        $sb = new SubCategory();
        $categoryTable = $sb->getTable();

        return DB::table($categoryTable)->where('id',$id)->get(['name']);

    }

    public static function getAccountName(int $id): string
    {

        $a = new Account();
        $accountTable = $a->getTable();

        return DB::table($accountTable)->where('id',$id)->get(['name']);

    }

    private function getType(): void
    {
        if(!empty($this->type)) {
            $this->query->whereIn('type',$this->type);
        }
    }
}
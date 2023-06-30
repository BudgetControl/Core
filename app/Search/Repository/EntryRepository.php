<?php

namespace Search\Repository;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Entry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use DateTime;
use App\Http\Services\UserService;
use Illuminate\Database\Query\Builder;

class EntryRepository {

    const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var DB */
    protected $query;

    public function __construct()
    {
        $this->query = DB::table('entries');
        //$this->query->with('label')->with('subCategory.category')->with('account')->withTrashed()->orderBy('date_time','desc')
        //->where('user_id',UserService::getCacheUserID());
    }

    public function get(array $column = ['*']): Collection
    {
        return $this->query->get($column);
    }

    public function getById(array $ids,array $column = ['*']): Collection
    {
        return $this->query->whereIn('id',$ids)->get($column);
    }

    public function getByUuid(array $ids,array $column = ['*']): Collection
    {
        return $this->query->whereIn('uuid',$ids)->get($column);
    }

    public function incoming(): self
    {
        $this->query->where('type',EntryType::Incoming->value);
        return $this;
    }

    public function expenses(): self
    {
        $this->query->where('type',EntryType::Expenses->value);
        return $this;
    }

    public function transfer(): self
    {
        $this->query->where('type',EntryType::Transfer->value);
        return $this;
    }

    public function debit(): self
    {
        $this->query->where('type',EntryType::Debit->value);
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
}
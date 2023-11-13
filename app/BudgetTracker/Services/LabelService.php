<?php

namespace App\BudgetTracker\Services;

use Exception;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Labels;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class LabelService implements BudgetTrackerService
{
    private Builder|Model $label;

    const CREATE = 1;
    const SELECT = 2;

    public function __construct(?int $mode = null)
    {
        switch($mode) {
            case self::CREATE:
                $label = new Labels();
                break;
            case self::SELECT:
                $label = Labels::User();
                break;
            default:
                $label = Labels::User();
                break;
                
        }

        $this->label = $label;
    }

    /**
     *  read repository
     *
     *  @param bool $value for where clause
     *  @return self
     */
    public function archived(bool $value = false): self
    {
        $this->label->where('archive',$value);

        return $this;
    }

    /**
     *  read repository
     *
     *  @param mixed $field for where clause
     *  @return self
     */
    public function read(mixed $field): self
    {
        $this->label->where('id', $field);

        return $this;
    }

    /**
     *  save repository
     *
     *  @param array $data for where clause
     *  @return void
     */
    public function save(array $data): void
    {
        /** @var Labels $label */
        $label = $this->label;
        $label->name = $data['name'];
        $label->color = $data['name'];
        $label->user_id = UserService::getCacheUserID();
        $label->validate();

        $label->save();
    }

    /**
     *  delete from repository
     *
     *  @param mixed $field for where clause
     *  @return void
     */
    public function delete(mixed $field): void
    {
        $this->label->delete();
    }

    /**
     *  get collection repository
     *
     *  @param mixed $field for where clause
     *  @return Collection
     */
    public function get(): Collection
    {
        $label = $this->label->get('*');

        return $label;
    }

    /**
     *  order by
     *
     *  @param string $field for where clause
     *  @return self
     */
    public function order(string $field): self
    {
        $this->label->orderBy($field);

        return $this;
    }

    /**
     *  add filter
     *
     *  @param string $column
     *  @param mixed $values
     *
     *  @return self
     */
    public function filter(string $column, mixed $values): self
    {
        if(is_array($values)) {
            $this->label->adnWhereIn($column, $values);
        } else {
            $this->label->adnWhere($column, $values);
        }

        return $this;
    }
}


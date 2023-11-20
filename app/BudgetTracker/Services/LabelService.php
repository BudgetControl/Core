<?php

namespace App\BudgetTracker\Services;

use Exception;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Labels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\BudgetTracker\Entity\BudgetTracker;
use Illuminate\Database\Eloquent\Collection;
use App\BudgetTracker\Services\BudgetTrackerService;

class LabelService implements BudgetTrackerService
{
    private Builder|Model $label;

    
    private function __construct(Builder|Model $label)
    {
        $this->label = $label;
    }

    /**
     * create new instance 
     * @param int $id
     * 
     * @return self
     */
    public static function create(): self
    {
        return new LabelService(
            new Labels()
        );
    }

    /**
     * find an instance 
     * @param int $id
     * 
     * @return self
     */
    public static function find(int $id): self
    {   
        return new LabelService(
            Labels::User()->where('id',$id)
        );
    }

    /**
     * select all instance 
     * @param int $id
     * 
     * @return self
     */
    public static function select(): self
    {
        return new LabelService(
            Labels::User()
        );
    }

    /**
     *  read repository
     *
     *  @param bool $value for where clause
     *  @return self
     */
    public function archived(int $value = 0): self
    {
        $this->label->where('archive',0);
        if($value === 1) {
            $this->label->where('archive',1);
        }

        return $this;
    }

    /**
     *  save repository
     *
     *  @param BudgetTracker $data for where clause
     *  @return void
     */
    public function update(BudgetTracker $data): void
    {
        /** @var \App\BudgetTracker\Entity\Label $data */
        $label = $this->label->first();
        $label->name = $data->getName();
        $label->color = $data->getColor();
        $label->archive = $data->getArchive();
        $label->user_id = UserService::getCacheUserID();

        $label->save();
    }

    /**
     *  save repository
     *
     *  @param BudgetTracker $data for where clause
     *  @return void
     */
    public function save(BudgetTracker $data): void
    {
        /** @var \App\BudgetTracker\Entity\Label $data */
        $label = $this->label;
        $label->name = $data->getName();
        $label->color = $data->getColor();
        $label->archive = $data->getArchive();
        $label->user_id = UserService::getCacheUserID();

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
        return $this->label->get('*');
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


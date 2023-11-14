<?php
namespace App\BudgetTracker\Services;

use App\BudgetTracker\Entity\BudgetTracker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BudgetTrackerService {

    
    /**
     * create new instance 
     * @param int $id
     * 
     * @return self
     */
    public static function create(): self;

    /**
     * find an instance 
     * @param int $id
     * 
     * @return self
     */
    public static function find(int $id): self;

    /**
     * select all instance 
     * @param int $id
     * 
     * @return self
     */
    public static function select(): self;

        /**
     *  save repository
     * 
     *  @param array $data for where clause
     *  @return void
     */
    public function save(BudgetTracker $data): void;

    /**
     *  save repository
     *
     *  @param BudgetTracker $data for where clause
     *  @return void
     */
    public function update(BudgetTracker $data): void;

    /**
     *  delete from repository
     * 
     *  @param mixed $field for where clause
     *  @return void
     */
    public function delete(mixed $field): void;

    /**
     *  get collection repository
     * 
     *  @param mixed $field for where clause
     *  @return Collection
     */
    public function get(): Collection;


}
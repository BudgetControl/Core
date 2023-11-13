<?php
namespace App\BudgetTracker\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BudgetTrackerService {

    /**
     *  read repository
     * 
     *  @param mixed $field for where clause
     *  @return self
     */
    public function read(mixed $field): self;

        /**
     *  save repository
     * 
     *  @param array $data for where clause
     *  @return void
     */
    public function save(array $data): void;

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
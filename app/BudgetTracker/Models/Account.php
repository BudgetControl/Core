<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;


class Account extends Model
{
    use HasFactory, SoftDeletes;

    public $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
      ];

        /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(array $attributes = []): Factory
    {
        return AccountFactory::new($attributes);
    }

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    /**
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {   
        parent::__construct($attributes);
        
        $this->attributes['date_time'] = date('Y-m-d H:i:s',time());
        $this->attributes['uuid'] = uniqid();
        
    }

}

<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\factories\TransferFactory;
use Illuminate\Database\Eloquent\Factories\Factory;


class Transfer extends Entry
{
    use HasFactory;

    /**
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {   
        parent::__construct($attributes);
        
        $this->attributes['type'] = EntryType::Transfer->value;
        $this->attributes['transfer'] = 1;
        $this->attributes['category_id'] = 75;
        
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return TransferFactory::new();
    }

    /**
     * Get all of the models from the database.
     *
     * @param  array|string  $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, static>
     */
    public static function all($columns = ['*'])
    {
        $query = parent::all($columns);
        return $query->where('type',EntryType::Transfer->value);
    }
}

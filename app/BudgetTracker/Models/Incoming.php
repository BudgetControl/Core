<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\factories\IncomingFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Incoming extends Entry
{
    use HasFactory;

    /**
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {   
        parent::__construct($attributes);
        
        $this->attributes['type'] = EntryType::Incoming->value;
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(array $attributes = []): Factory
    {
        return IncomingFactory::new($attributes);
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
        return $query->where('type',EntryType::Incoming->value);
    }

}

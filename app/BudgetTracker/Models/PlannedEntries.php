<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\factories\PlannedEntriesFactory;
use App\BudgetTracker\Models\Entry;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlannedEntries extends Entry
{
    use HasFactory,SoftDeletes;

    protected $table = 'planned_entries';

    protected $fillable = ['type'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->attributes['date_time'] = time();
        $this->attributes['uuid'] = uniqid();
        $this->attributes['confirmed'] = 1;
        $this->attributes['planned'] = 1;

        foreach($attributes as $k => $v) {
            $this->$k = $v;
        }
    }

        /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(array $attributes = []): Factory
    {
        return PlannedEntriesFactory::new($attributes);
    }

}

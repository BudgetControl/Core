<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\Factories\PlannedEntriesFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Services\UserService;

class PlannedEntries extends Model
{
    use HasFactory,SoftDeletes;

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
        'updated_at'  => 'date:Y-m-d',
        'deletad_at'  => 'date:Y-m-d',
        'date_time' =>  'date:Y-m-d H:i:s'
    ];

    protected $table = 'planned_entries';

    protected $fillable = ['type'];

    public function __construct(array $attributes = [])
    {
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

    /**
     * scope user
     */
    public function scopeUser($query): void
    {
        $query->where('user_id',UserService::getCacheUserID());
    }

    /**
     * Get the category
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, "category_id");
    }

    /**
     * Get the currency
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the payments_type
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the payments_type
     */
    public function paymentType()
    {
        return $this->belongsTo(PaymentsTypes::class);
    }

}

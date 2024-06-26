<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\User\Services\UserService;
use Illuminate\Database\Eloquent\Builder;

class Account extends BaseModel
{
    use HasFactory, SoftDeletes;

    const DEFAULT = '64b59d6nob752';

    protected  $fillable = [
        'sorting'
    ];

    public $hidden = [
        "created_at",
        "updated_at",
      ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
        'updated_at'  => 'date:Y-m-d',
        'deletad_at'  => 'date:Y-m-d',
        'date_time' =>  'date:Y-m-d H:i:s'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->attributes['date_time'] = date('Y-m-d H:i:s',time());
        $this->attributes['uuid'] = \Ramsey\Uuid\Uuid::uuid4()->toString();;

        foreach($attributes as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(array $attributes = []): Factory
    {
        return AccountFactory::new($attributes);
    }

    
    /**
     *  find with specify uuid
     *  @param string $uuid
     *  
     *  @return Entry
     * */
    public static function findFromUuid(string $uuid): Account
    {
        return Account::where('uuid',$uuid)->firstOrFail();
    }

    /**
     * scope user
     */
    public function scopeStats(Builder $query): void
    {
        $query->User()->where('exclude_from_stats',0);
    }

    public function scopeSorting(Builder $query): void
    {
        $query->orderBy("sorting");
    }


}

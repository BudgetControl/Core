<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\Factories\AccountFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Services\UserService;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    public $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
      ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
        'updated_at'  => 'date:Y-m-d',
        'deletad_at'  => 'date:Y-m-d',
        'date_time' =>  'date:Y-m-d h:i:s'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->attributes['date_time'] = date('Y-m-d H:i:s',time());
        $this->attributes['uuid'] = uniqid();
        if(empty($this->attributes['user_id'])) {
            $this->attributes['user_id'] = UserService::getCacheUserID();
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
    public static function findFromUuid(string $uuid): Entry
    {
        return Account::where('uuid',$uuid)->where('user_id',UserService::getCacheUserID())->firstOrFail();
    }

    /**
     * scope user
     */
    public function scopeUser($query): void
    {
        $query->where('user_id',UserService::getCacheUserID());
    }


}

<?php
namespace App\Budget\Domain\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User\Services\UserService;

class Budget extends Model
{
    use SoftDeletes;

    protected $table = 'budgets';

    public $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
      ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
        'updated_at'  => 'date:Y-m-d',
        'deletad_at'  => 'date:Y-m-d',
    ];

    /**
     * scope user
     */
    public function scopeUser($query): void
    {
        $query->where('budgets.user_id',UserService::getCacheUserID());
    }


}
<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User\Services\UserService;
use Illuminate\Database\Eloquent\SoftDeletes;

class Models extends Model
{
  use HasFactory,SoftDeletes;

  public $hidden = [
    "created_at",
    "updated_at",
    "deleted_at"
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);

    if (empty($this->attributes['user_id'])) {
      $this->attributes['user_id'] = UserService::getCacheUserID();
    }

    foreach ($attributes as $k => $v) {
      $this->$k = $v;
    }
  }


  /**
   * The users that belong to the role.
   */
  public function label()
  {
    return $this->belongsToMany(Labels::class, 'model_labels');
  }

  /**
   * scope user
   */
  public function scopeUser($query): void
  {
    $query->where('user_id', UserService::getCacheUserID());
  }
}

<?php

namespace App\BudgetTracker\Models;

use App\BudgetTracker\Factories\ModelsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User\Services\UserService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;

class Models extends BaseModel
{
  use HasFactory, SoftDeletes;

  public $hidden = [
    "created_at",
    "updated_at",
  ];

  protected $casts = [
    'created_at'  => 'date:Y-m-d',
    'updated_at'  => 'date:Y-m-d',
    'deletad_at'  => 'date:Y-m-d',
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);

    foreach ($attributes as $k => $v) {
      $this->$k = $v;
    }
  }

  /**
   * Create a new factory instance for the model.
   */
  protected static function newFactory(array $attributes = []): Factory
  {
    return ModelsFactory::new($attributes);
  }

  /**
   * The users that belong to the role.
   */
  public function label()
  {
    return $this->belongsToMany(Labels::class, 'model_labels');
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


  /**
   * Get the category
   */
  public function subCategory()
  {
    return $this->belongsTo(SubCategory::class, "category_id");
  }

  /**
   * with relations
   */
  public function scopeWithRelations($query): void
  {
    $query->with('label')->with('subCategory.category')->with('account')->with('currency');
  }
}

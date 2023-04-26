<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;

    public $hidden = [
      "created_at",
      "updated_at",
      "deleted_at"
    ];


        /**
       * The users that belong to the role.
       */
      public function label()
      {
          return $this->belongsToMany(Labels::class, 'model_labels');
      }
}

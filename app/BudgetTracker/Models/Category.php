<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $hidden = [
      "created_at",
      "updated_at",
      "deleted_at"
    ];

    /**
     * Get the subCategories.
     */
    public function subcategory() {
       return $this->hasMany(SubCategory::class);
    }
}

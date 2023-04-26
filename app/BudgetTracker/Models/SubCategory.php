<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    public $hidden = [
      "created_at",
      "updated_at",
      "deleted_at"
    ];

    public function category() {
       return $this->belongsTo(Category::class);
    }

    /**
     * Get the subCategories.
     */
    public function entry() {
       return $this->hasMany(Entry::class);
    }
}

<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labels extends Model
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
  public function entries()
  {
      return $this->belongsToMany(Entry::class, 'entry_labels');
  }


      /**
     * The users that belong to the role.
     */
    public function models()
    {
        return $this->belongsToMany(Models::class, 'model_labels');
    }

    /**
     * override get method for not return trashed elements
     * 
     * @return \Illuminate\Database\Eloquent\Collection<int, static>
     */
    public function get($columns = ['*']) {
        $results = parent::get($columns);
        return $results->withoutTrashed();
    }
}

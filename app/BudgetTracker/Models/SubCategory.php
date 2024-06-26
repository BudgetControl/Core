<?php

namespace App\BudgetTracker\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User\Services\UserService;
use Illuminate\Database\Eloquent\Builder;

class SubCategory extends BaseModel
{
    use HasFactory;

    public $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['date_time'] = date('Y-m-d H:i:s', time());
        $this->attributes['uuid'] = \Ramsey\Uuid\Uuid::uuid4()->toString();;

        foreach ($attributes as $k => $v) {
            $this->$k = $v;
        }
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the subCategories.
     */
    public function entry()
    {
        return $this->hasMany(Entry::class);
    }

    // Definisci un query scope per aggiungere la condizione "where workspace_id = x"
    public function scopeUser($query)
    {
        return $query->where('workspace_id', UserService::getCacheUserID())->where('workspace_id', 0);
    }
}

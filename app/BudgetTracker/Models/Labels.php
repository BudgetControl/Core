<?php

namespace App\BudgetTracker\Models;

use App\User\Services\UserService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Rules\Account\AccountTypeValidation;
use App\Rules\Account\AccountColorValidation;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\BudgetTracker\Factories\LabelsFactory;
use App\Rules\Account\AccountCurrencyValidation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Labels extends Model
{
    use HasFactory,SoftDeletes;

    public $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
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
        return LabelsFactory::new($attributes);
    }

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
}

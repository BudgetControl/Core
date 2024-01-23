<?php
namespace App\Budget\Domain\Model;

use App\Budget\Domain\Factories\BudgetFactory;
use App\User\Services\UserService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class Budget extends Model
{
    use HasFactory, SoftDeletes;

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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->attributes['uuid'] = uniqid();

        foreach($attributes as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(array $attributes = []): Factory
    {
        return BudgetFactory::new($attributes);
    }

}
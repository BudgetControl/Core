<?php
namespace App\BudgetTracker\Models;

use App\User\Services\UserService;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model {

        use HasFactory, SoftDeletes;

        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);

            if(empty($this->attributes['workspace_id'])) {
                $this->attributes['workspace_id'] = UserService::getCacheUserID();
            }
            foreach($attributes as $k => $v) {
                $this->$k = $v;
            }
        }

        // Definisci un query scope per aggiungere la condizione "where workspace_id = x"
        public function scopeUser($query)
        {
            return $query->where('workspace_id', UserService::getCacheUserID());
        }

}
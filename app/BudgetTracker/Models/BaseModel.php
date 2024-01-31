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

            //FIXME:
            $id = UserService::getCacheUserID();
            if($id === 0) {
                $this->attributes['user_id'] = $id;
            }
    
            foreach($attributes as $k => $v) {
                $this->$k = $v;
            }
        }

        // Definisci un query scope per aggiungere la condizione "where user_id = x"
        public function scopeUser($query)
        {
            return $query->where('user_id', UserService::getCacheUserID());
        }

}
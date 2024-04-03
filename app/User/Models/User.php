<?php

namespace App\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use App\User\Models\PersonalAccessToken;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Encryptable, SoftDeletes;

    public $link;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['uuid'] = \Ramsey\Uuid\Uuid::uuid4()->toString();;
        foreach($attributes as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['password','updated_at'];

    /**
     *  encryptable data
     */

     protected $encryptable = [
        'email'
    ];

}

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

    /**
     *  encryptable data
     */

     protected $encryptable = [
        'email'
    ];

}

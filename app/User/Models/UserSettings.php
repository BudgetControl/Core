<?php

namespace App\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    use HasFactory, HasApiTokens, Encryptable;

    protected $table = "user_settings";

}

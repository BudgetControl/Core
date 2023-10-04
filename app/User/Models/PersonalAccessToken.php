<?php

namespace App\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as PersonalAccessTokenModel;

class PersonalAccessToken extends PersonalAccessTokenModel
{
    /**
     * Find the token instance matching the given token.
     *
     * @param  string  $token
     * @return static|null
     */
    public static function findToken($token)
    {
        return static::where('token', $token)->where('expires_at', '>', date('Y-m-d H:i:s',time()))->first();
    }
}

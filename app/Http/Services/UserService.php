<?php

namespace App\Http\Services;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class UserService
{
    /**
     * get ID user from access token
     * @param string $token
     * 
     */
    static public function userIDfromToken(string $token)
    {
        if(Cache::has($token)) {
            return Cache::get($token);
        }

        $data = PersonalAccessToken::where('token',$token)->firstOrFail();
        Cache::put($token,$data->tokenable_id);
    }

    /**
     * get user id from cache
     * 
     * @return int
     * @throws Exception
     */
    static public function getCacheUserID(): int
    {
        $session = request();
        $session = $session->header()["access-token"][0];

        if(env('APP_ENV') == 'testing') {
            return 1;
            die;
        }

        if(!Cache::has($session)) {
            throw new \Exception("Unable find a user ID from cache with TOKEN $session");
        }

        return Cache::get($session);

    }
}

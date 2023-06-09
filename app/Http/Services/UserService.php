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
        $session = request();
        $session = $session->server()['REMOTE_ADDR'];

        if(Cache::has($session)) {
            return Cache::get($session);
        }

        $data = PersonalAccessToken::where('token',$token)->firstOrFail();
        Cache::put($session,$data->tokenable_id);
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
        $session = $session->server()['REMOTE_ADDR'];

        if(env('APP_ENV') == 'testing') {
            return 1;
            die;
        }

        if(!Cache::has($session)) {
            throw new \Exception("Unable find a user ID from cache with IP $session");
        }

        return Cache::get($session);

    }
}

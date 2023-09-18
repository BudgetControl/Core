<?php

namespace App\Http\Services;

use App\Http\Exceptions\AuthException;
use App\Models\PersonalAccessToken;
use App\Models\User;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public User $user;

    public function signUp(array $request)
    {
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();

        $this->user = $user;
        $this->user->link = $this->link($user);


        return $user;
    }

    public function link(User $user): string
    {
        $key = (string) $user->email->email.$user->password.$user->name.microtime();
        return $this->generateToken($key);
    }

    /**
     * confirm user
     */
    public function confirm(string $key): bool
    {
        $user = $this->retriveToken($key);
        if(empty($user)) {
            return false;
        }

        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        return true;
    }

    /**
     * generate new personal token
     * 
     * @return string
     * @throw Exception
     */
    private function generateToken(string $pattern): string
    {
        $expireLink = date("Y-m-d H:i:s", strtotime('+3 hours'));
        $link = sha1($pattern);
        Cache::set($link,$this->user,strtotime($expireLink));

        return $link;
    }

    public function retriveToken(string $key): User
    {
        $user = Cache::get($key);

        if(empty($user)) {
            throw new AuthException("Token is not valid");
        }

        Cache::delete($key);

        return $user;
    }


}

<?php

namespace App\User\Services;

use App\User\Exceptions\AuthException;
use App\User\Models\Entity\SettingValues;
use App\User\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class AuthService
{
    public ?User $user;

    public function __construct(User|null $user = null)
    {
        $this->user = $user;
    }

    public function signUp(array $request)
    {
        $user = new User();
        $user->uuid = uniqid();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();

        $this->user = $user;

        return $user;
    }

    public function token(): string
    {
        $key = (string) $this->user->email->email . $this->user->password . $this->user->name . microtime();
        return self::generateToken($key);
    }

    /**
     * confirm user
     */
    public function confirm(string $key): bool
    {
        $user = $this->retriveToken($key);
        if (empty($user)) {
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
        Cache::set($link, $this->user, strtotime($expireLink));

        return $link;
    }

    public function retriveToken(string $key): User
    {
        $user = Cache::get($key);

        if (empty($user)) {
            throw new AuthException("Token is not valid");
        }

        Cache::delete($key);

        return $user;
    }

    /**
     * create first account
     */
    public function createAccountEntry()
    {
        $uuid = uniqid();
        $dateTIme = date("Y-m-d H:i:s", time());
        Log::info("Create new Account entry");
        DB::statement('
            INSERT INTO accounts
            (uuid,date_time,name,color,type,balance,installementValue,currency,exclude_from_stats)
            VALUES
            ("' . $uuid . '","' . $dateTIme . '","Cash","#C6C6C6","Cash",0,0,"EUR",0)
        ');
    }

    /**
     * create first account
     */
    public function setUpDefaultSettings()
    {
        Log::info("Set up default settings");
        $configurations = SettingValues::Configurations->value;
        DB::statement('
            INSERT INTO user_settings
            (setting,data)
            VALUES
            ("'.$configurations.'",{"currency_id":1,"payment_type_id":1})
        ');
    }
}

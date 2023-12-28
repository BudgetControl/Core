<?php

namespace App\User\Services;

use App\BudgetTracker\Models\Currency;
use App\BudgetTracker\Models\PaymentsTypes;
use App\User\Models\User;
use App\User\Models\UserSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\User\Models\PersonalAccessToken;

class UserService
{
    private readonly string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * retrive user
     */

    public function get(): User
    {
        $token = $this->token;
        $tokenCache = PersonalAccessToken::findToken($token);
        $user = User::find($tokenCache->tokenable_id);
        $this->userIDfromToken($token);

        return $user;
    }
    /**
     * get ID user from access token
     * @param string $token
     * 
     */
    static public function userIDfromToken(string $token)
    {
        $session = session()->getId();

        if (Cache::has($session)) {
            Log::info("Current session $session");
            return Cache::get($session);
        }

        $data = PersonalAccessToken::where('token', $token)->firstOrFail();
        Cache::put($session, $data->tokenable_id);
    }

    /**
     * get user id from cache
     * 
     * @return int
     * @throws Exception
     */
    static public function getCacheUserID(): int
    {

        if (env("APP_DISABLE_AUTH", false) === true) {
            Log::info("Start session DEBUG MODE");
            return 1;
        }

        $session = session()->getId();

        if (!Cache::has($session)) {
            throw new \Exception("Unable find a user ID from cache with IP $session");
        }

        return Cache::get($session);
    }

    /**
     * retrive setting informations
     */
    public static function getSettings()
    {
        $setting = UserSettings::where("user_id",UserService::getCacheUserID())->first();
        $userProfile = User::find($setting->id);
        $currency = Currency::find($setting->currency_id);
        $paymentType = PaymentsTypes::find($setting->payment_type_id);

        return [
            'settings' => $setting,
            'user_profile' => $userProfile,
            'currency' => $currency,
            'paymentType' => $paymentType
        ];

    }
}

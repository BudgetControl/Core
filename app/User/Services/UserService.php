<?php

namespace App\User\Services;

use App\Auth\Entity\Cognito\AccessToken;
use App\User\Models\User;
use App\User\Models\UserSettings;
use App\BudgetTracker\Entity\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\BudgetTracker\Models\Currency;
use App\User\Exceptions\UserException;
use App\User\Models\Entity\SettingValues;
use App\BudgetTracker\Models\PaymentsTypes;

class UserService
{

    /**
     * retrive user
     */
    public static function get(): User
    {
        $cacheKey = session()->getId().'user';
        return Cache::create($cacheKey)->get();
    }

    /**
     * getCacheUserID
     */
    public static function getCacheUserID(): int
    {
        return 1;
        
        $cacheKey = session()->getId().'user';
        $id = Cache::create($cacheKey.'id')->get();

        if(empty($id)) {
            $id = 0;
            if(config("app.env") == "testing") {
            }
        }

        return $id;
    }

    /**
     * set user obj on cache
     * @param User $user
     * 
     */
    public static function setUserCache(User $user)
    {
        $cacheKey = session()->getId().'user';
        Cache::create($cacheKey)->set($user);
        Cache::create($cacheKey.'id')->set($user->id);
    }

    /**
     * set user obj on cache
     * @param User $user
     * 
     */
    public static function setTokenCache(AccessToken $token)
    {
        $cacheKey = session()->getId().'access_token';
        Cache::create($cacheKey)->set($token->value());
    }

    /**
     * set user obj on cache
     * @param User $user
     * 
     */
    public static function getTokenCache(): string
    {
        $cacheKey = session()->getId().'access_token';
        return Cache::create($cacheKey)->get();
    }

    /**
     * clar user cache
     */
    public static function clearUserCache()
    {
        $cacheKey = session()->getId().'user';
        Cache::create($cacheKey)->delete();
    }

    /**
     * retrive setting informations
     */
    public static function getSettings()
    {   
        $cacheKey = session()->getId().'user';
        $user =  Cache::create($cacheKey)->get();

        $setting = UserSettings::where("setting", SettingValues::Configurations->value)->first();
        $userProfile = $user;
        $app_setting = json_decode($setting->data);
        $currency = Currency::find($app_setting->currency_id);
        $paymentType = PaymentsTypes::find($app_setting->payment_type_id);

        return [
            'settings' => $setting,
            'user_profile' => $userProfile,
            'currency' => $currency,
            'paymentType' => $paymentType
        ];

    }
}

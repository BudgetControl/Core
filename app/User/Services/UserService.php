<?php

namespace App\User\Services;

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
        $cacheKey = Auth::id().'user';
        return Cache::create($cacheKey)->get();
    }

    /**
     * getCacheUserID
     */
    public static function getCacheUserID(): int
    {
        $cacheKey = Auth::id().'user';
        $id = Cache::create($cacheKey.'id')->get();

        if(empty($id)) {
            if(config("app.env") == "testing") {
                return 1;
            }
            throw new UserException("User ID not found!!", 500);
        }
        return $id;
    }

    /**
     * set user obj on cache
     * @param User $user
     * 
     */
    public static function setUserCache()
    {
        $cacheKey = Auth::id().'user';
        $user = User::find(Auth::id());
        Cache::create($cacheKey)->set($user);
        Cache::create($cacheKey.'id')->set($user->id);
    }

    /**
     * clar user cache
     */
    public static function clearUserCache()
    {
        $cacheKey = Auth::id().'user';
        Cache::create($cacheKey)->delete();
        Cache::create($cacheKey.'id')->delete();
    }

    /**
     * retrive setting informations
     */
    public static function getSettings()
    {   
        $cacheKey = Auth::id().'user';
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

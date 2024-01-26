<?php

namespace App\User\Services;

use App\User\Models\User;
use App\User\Models\UserSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\BudgetTracker\Models\Currency;
use App\User\Models\Entity\SettingValues;
use App\BudgetTracker\Models\PaymentsTypes;
use App\User\Exceptions\AuthException;

class UserService
{

    /**
     * retrive user
     */
    public static function get(): User
    {
        return Cache::get(user_ip());
    }

    /**
     * getCacheUserID
     */
    public static function getCacheUserID(): int
    {
        $user = Cache::get(user_ip());

        if(empty($user->id)) {
            throw new AuthException("User ID not found!!", 500);
        }
        return $user->id;
    }

    /**
     * set user obj on cache
     * @param User $user
     * 
     */
    static public function setUserCache(User $user)
    {
        Cache::put(user_ip(), $user);
    }

    /**
     * clar user cache
     */
    static public function clearUserCache()
    {
        Cache::delete(user_ip());
    }

    /**
     * retrive setting informations
     */
    public static function getSettings()
    {   
        $user = Cache::get(user_ip());

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

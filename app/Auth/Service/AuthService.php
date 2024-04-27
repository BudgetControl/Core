<?php

namespace App\Auth\Service;

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

    /**
     * create first account
     */
    public static function createAccountEntry(int $userID)
    {
        $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();;
        $dateTIme = date("Y-m-d H:i:s", time());
        Log::info("Create new Account entry");
        DB::statement('
            INSERT INTO accounts
            (uuid,date_time,name,color,type,balance,installementValue,currency,exclude_from_stats,workspace_id)
            VALUES
            ("' . $uuid . '","' . $dateTIme . '","Cash","#C6C6C6","Cash",0,0,"EUR",0,'.$userID.')
        ');
    }

    /**
     * create first account
     */
    public static function setUpDefaultSettings(int $userID)
    {
        Log::info("Set up default settings");
        $configurations = SettingValues::Configurations->value;
        DB::statement('
            INSERT INTO user_settings
            (setting,data,workspace_id)
            VALUES
            ("'.$configurations.'","{\"currency_id\":1,\"payment_type_id\":1}",'.$userID.')
        ');
    }

}

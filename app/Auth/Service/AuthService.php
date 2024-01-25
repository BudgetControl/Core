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
     * generate new personal token
     * 
     * @return string
     * @throw Exception
     */
    private function generateToken(string $pattern): string
    {
        $expireLink = date("Y-m-d H:i:s", strtotime('+3 hours'));
        $link = sha1($pattern);
        // Cache::set($link, $this->user, strtotime($expireLink));

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
     * create new databases
     */
    public static function createDatabse(string $name)
    {
        if(env("APP_ENV") == "testing") {
            $name = "budgetV2_phpunit";
        }

        Log::info("CREATE DATABASE $name");
        DB::statement('CREATE DATABASE ' . $name);
    }

    /**
     * drop databases if somthings wront
     */
    public static function dropDatabse(string $name)
    {
        if(env("APP_ENV") == "testing") {
            $name = "budgetV2_phpunit";
        }

        Log::info("DROP DATABASE $name");
        DB::statement('DROP DATABASE ' . $name);
    }

    /**
     * create first account
     */
    public static function createAccountEntry()
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
    public static function setUpDefaultSettings()
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

    /**
     * make migrations
     */
    public static function migrate(string $dbName)
    {

        if(env("APP_ENV") == "testing") {
            $dbName = "budgetV2_phpunit";
        }

        Config::set(['database.connections.mysql.database' => $dbName]);
        DB::purge('mysql');
        DB::reconnect('mysql');
        Log::info("Start migration of DB $dbName");
        // Esegui la migrazione o altri comandi desiderati
        Artisan::call(
            'migrate',
            [
                '--path' => 'database/migrations/users',
                '--force' => true
            ]
        );

        Artisan::call('db:seed', [
            '--class' => '\Database\Seeders\AppConfigurationsSeeder'
        ]);
    }
}

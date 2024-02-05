<?php

namespace Database\Seeders;

use App\User\Models\User;
use Illuminate\Database\Seeder;
use App\User\Models\UserSettings;
use App\User\Models\Entity\SettingValues;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSettingsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new UserSettings();
        $setting->setting =  SettingValues::Configurations->value;
        $setting->data = '{"payment_type_id":1,"currency_id":1}';
        $setting->user_id = config('app.config.demo_user_id');
        $setting->save();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\User\Models\User;
use App\User\Models\UserSettings;

class UserSettingsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = new UserSettings();
        $setting->setting = "app_configurations";
        $setting->data = '{"payment_type_id":1,"currendy_id":1}';
        $setting->save();
    }
}

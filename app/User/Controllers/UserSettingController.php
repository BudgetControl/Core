<?php
namespace App\User\Controllers;

use App\User\Models\UserSettings;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Currency;
use App\User\Models\Entity\SettingValues;
use Illuminate\Http\Request;
use Http\Discovery\Exception\NotFoundException;

class UserSettingController {

    public function index() {
        
        $setting = UserService::getSettings();

        if(!$setting) {
            throw new NotFoundException("User not found", 404);
        }

        return response()->json($setting);
    }

    public function setDefaultCurrency(Request $request)
    {
        $currency = Currency::find($request->currency);
        if(!$currency) {
            throw new NotFoundException("Currency not found", 404);
        }

        $setting = UserSettings::where("setting",SettingValues::Configurations->value)->first();
        if(!$setting) {
            throw new NotFoundException("User not found", 404);
        }

        $config = json_decode($setting->data);
        $config->currency_id = $request->currency;

        $setting->data = json_encode($config);
        $setting->save();

        return response()->json(["succedd" => "Updated currency"]);

    }
}
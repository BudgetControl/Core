<?php
namespace App\User\Controllers;

use App\User\Models\UserSettings;
use App\User\Services\UserService;
use App\BudgetTracker\Models\Currency;
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

        $setting = UserSettings::where("user_id",UserService::getCacheUserID())->first();
        if(!$setting) {
            throw new NotFoundException("User not found", 404);
        }

        $setting->currency_id = $request->currency;
        $setting->save();

        return response()->json(["succedd" => "Updated currency"]);

    }
}
<?php

namespace App\User\Controllers;

use App\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User\Services\UserService;
use App\Stats\Services\StatsService;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\Models;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Models\PlannedEntries;
use App\BudgetTracker\Models\SubCategory;
use App\User\Exceptions\AuthException;
use App\User\Models\UserSettings;

class ProfileController extends Controller
{
    /** 
     * retrive usef information 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {   
        $stats = new StatsService();

        $token = $request->header('X-ACCESS-TOKEN');
        $userService = new UserService($token);
        $user = $userService->get();

        if(!$user) {
            throw new AuthException("User is not logged");
        }

        $user->decrypted_email = $user->email->email;
        $user->total = $stats->total(false);
        $user->health = $stats->health(false);
        $user->incoming = $stats->incoming(false);
        $user->expenses = $stats->expenses(false);

        return response()->json($user);
    }

    public function delete(Request $request): JsonResponse
    {
        $token = $request->header('X-ACCESS-TOKEN');
        $userService = new UserService($token);
        $user = $userService->get();
        $userID = $user->id;

        $user->delete();
        UserSettings::where("user_id", $userID)->delete();
        Account::where("user_id", $userID)->delete();
        SubCategory::where("user_id", $userID)->delete();
        Entry::where("user_id", $userID)->delete();
        Labels::where("user_id", $userID)->delete();
        Models::where("user_id", $userID)->delete();
        Payee::where("user_id", $userID)->delete();
        PlannedEntries::where("user_id", $userID)->delete();


        return response()->json("User and all data deleted");
    }

    public function deleteData(Request $request): JsonResponse
    {
        $token = $request->header('X-ACCESS-TOKEN');
        $userService = new UserService($token);
        $user = $userService->get();

        $userID = $user->id;

        Account::where("user_id", $userID)->delete();
        SubCategory::where("user_id", $userID)->delete();
        Entry::where("user_id", $userID)->delete();
        Labels::where("user_id", $userID)->delete();
        Models::where("user_id", $userID)->delete();
        Payee::where("user_id", $userID)->delete();
        PlannedEntries::where("user_id", $userID)->delete();

        return response()->json("User and all data deleted");
    }
}
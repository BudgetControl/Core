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
        UserSettings::get()->delete();
        Account::get()->delete();
        SubCategory::get()->delete();
        Entry::get()->delete();
        Labels::get()->delete();
        Models::get()->delete();
        Payee::get()->delete();
        PlannedEntries::get()->delete();


        return response()->json("User and all data deleted");
    }

    public function deleteData(Request $request): JsonResponse
    {
        $token = $request->header('X-ACCESS-TOKEN');
        $userService = new UserService($token);
        $user = $userService->get();

        $userID = $user->id;

        Account::get()->delete();
        SubCategory::get()->delete();
        Entry::get()->delete();
        Labels::get()->delete();
        Models::get()->delete();
        Payee::get()->delete();
        PlannedEntries::get()->delete();

        return response()->json("User and all data deleted");
    }
}
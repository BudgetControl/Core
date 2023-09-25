<?php

namespace App\User\Controllers;

use App\User\Models\User;
use App\User\Exceptions\AuthException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\User\Services\UserService;
use App\Stats\Services\StatsService;

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

        $user->delete();

        return response()->json("User and all data deleted");
    }
}
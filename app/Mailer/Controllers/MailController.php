<?php

namespace App\Mailer\Controllers;

use App\User\Middleware\JsonResponse;
use App\User\Models\User;
use App\User\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MailController extends Controller {

    public function assistence(Request $request): JsonResponse
    {

        $userId = UserService::getCacheUserID();
        $user = User::find($userId);

        $message = $request->message;

    }
}
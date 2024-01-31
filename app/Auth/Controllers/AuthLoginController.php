<?php
namespace App\Auth\Controllers;

use Throwable;
use App\User\Models\User;
use App\Auth\Entity\Token;
use App\Traits\Encryptable;
use Illuminate\Http\Request;
use App\BudgetTracker\Entity\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Http\Client\Exception\HttpException;
use App\Auth\Entity\Cognito\CognitoToken;
use App\Auth\Service\CognitoClientService;
use App\User\Services\UserService;
use Ellaisys\Cognito\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class AuthLoginController {

    use AuthenticatesUsers, Encryptable;

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'rememberMe' => 'boolean'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $toCollect = [
            'email' => $request->email,
            'password' => $request->password,
            'crypted_email' => self::encrypt(['email' => $request->email]),
            'rememberMe' => $request->rememberMe
        ];

        try {
            $result = CognitoClientService::init($toCollect['email'])->authLogin($toCollect['password']);
            if(Auth::attempt([
                'email' => $toCollect['crypted_email'],
                'password' => $toCollect['password']
            ], $toCollect['rememberMe']) ) {
                
                /** @var \App\Auth\Entity\Cognito\AccessToken $token */
                $token = $result->getToken(CognitoToken::ACCESS);
                //save all informations in cache
                UserService::setUserCache();
                UserService::setTokenCache($token);
                Cache::create($token->value())->set(User::find(Auth::id()));

                return response()->json([
                    'success' => true,
                    'access_token' => $token->value()
                ]);
            }

        } catch (Throwable $e) {
            Log::error($e->getMessage());

        }

        return response()->json([
            "success" => false,
            "error" => "An error occuring, try later",
        ], 401);

    }

}
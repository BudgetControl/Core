<?php

namespace App\Auth\Middleware;

use App\Auth\Controllers\AuthLoginController;
use App\Auth\Entity\Cognito\AccessToken;
use App\Auth\Entity\Cognito\CognitoToken;
use App\Auth\Entity\JwtToken;
use App\Auth\Service\CognitoClientService;
use App\BudgetTracker\Entity\Cache;
use App\User\Models\User;
use App\User\Services\UserService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthCognitoMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next)
    {
        /** only fot php unit testting */
        if (@$_ENV['DISABLE_AUTH'] == true) {
            UserService::setUserCache(User::find(1));
            return $next($request);
        }

        $accessToken = str_replace('Bearer ', '', $request->header('authorization'));
        $accessToken = str_replace('Bearer ', '', $request->header('authorization'));

        $refreshToken = Cache::create($accessToken . 'refresh_token')->get();
        $accessToken = AccessToken::set($accessToken);

        try {
            $jwtToken = new JwtToken();
            $jwtToken->decode($accessToken->value());

            return $next($request);
        } catch (\Exception $e) {

            try {
                $user = Cache::create($accessToken->value())->get();
                $sub = $user->sub;
                // try with refresh token
                $result = CognitoClientService::init($sub)->refresh($refreshToken->value());
                $request->headers->set('authorization', $result->getToken(CognitoToken::ACCESS)->value(), true);

                UserService::setUserCache($user);

                return $next($request);

            } catch (Throwable $e) {

                // Gestisci le eccezioni durante la decodifica o la verifica del token di accesso
                Log::error('Error: ' . $e->getMessage());
                return response()->json([
                    "message" => "Not authorized"
                ], 401);
            }
        }
    }

}

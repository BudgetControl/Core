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
use Laravel\Sanctum\NewAccessToken;
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
        $refreshToken = Cache::create($accessToken . 'refresh_token')->get();

        $accessToken = AccessToken::set($accessToken);
        $user = Cache::create($accessToken->value())->get();

        try {
            $jwtToken = new JwtToken();
            $jwtToken->decode($accessToken->value());

            UserService::setUserCache($user);
            $response = $next($request);
            $response->headers->set('Authorization', "Bearer ".$accessToken->value(), true);
            return $response;
        } catch (\Exception $e) {

            //if token is expired delete it
            Cache::create($accessToken->value())->delete();

            try {
                $sub = $user->sub;
                // try with refresh token
                $result = CognitoClientService::init($sub)->refresh($refreshToken->value());

                $newAccessToken = $result->getToken(CognitoToken::ACCESS)->value();
                UserService::setUserCache($user);
                Cache::create($newAccessToken)->set($user,CACHE::TTL_FOREVER);

                $response = $next($request);
                $response->headers->set('Authorization', "Bearer ".$newAccessToken, true);

                return $response;

            } catch (Throwable $e) {

                // Gestisci le eccezioni durante la decodifica o la verifica del token di accesso
                Log::error('Error: ' . $e->getMessage());
                Log::debug("token ::: ".$accessToken->value());
                return response()->json([
                    "message" => "Not authorized"
                ], 401);
            }
        }
    }

}

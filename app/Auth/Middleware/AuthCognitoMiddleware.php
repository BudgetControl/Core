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
        if($_ENV['DISABLE_AUTH'] == true) {
            UserService::setUserCache(User::find(1));
            return $next($request);
        }

        $accessToken = str_replace('Bearer ','',$request->header('authorization'));
        $refreshToken = Cache::create($accessToken.'refresh_token')->get();
        $accessToken = AccessToken::set($accessToken);

        try {
            $jwtToken = new JwtToken();
            $decodedAccessToken = $jwtToken->decode($accessToken->value());

            $expirationTime = $decodedAccessToken['exp'];
            $currentTimestamp = time();

            if ($expirationTime < $currentTimestamp) {
                // token expired

                if ($refreshToken) {
                    try {
                        // try with refresh token
                        $decodedRefreshToken = $jwtToken->decode($refreshToken, JwtToken::REFRESH_TOKEN);
                        $refreshTokenExpirationTime = $decodedRefreshToken['exp'];

                        if ($refreshTokenExpirationTime >= $currentTimestamp) {
                            $user = Cache::create($accessToken.'user')->get();
                            $result = CognitoClientService::init($user->email->email)->refresh($refreshToken);

                            $request->headers->set('authorization',$result->getToken(CognitoToken::ACCESS)->value(),true);
                            $this->authenticate($accessToken);

                            return $next($request);

                        } else {
                            return response()->json([
                                "message" => "token expired"
                            ], 401);
                        }
                    } catch (\Exception $e) {
                        // Gestisci le eccezioni durante la decodifica o la verifica del refresh token
                        Log::error('Error: ' . $e->getMessage());
                        return response()->json([
                            "message" => "Not authorized"
                        ], 401);
                    }
                } else {
                    return response()->json([
                        "message" => "Refresh token not valid"
                    ], 401);
                }
            } else {
                $this->authenticate($accessToken);
                return $next($request);
            }
        } catch (\Exception $e) {
            // Gestisci le eccezioni durante la decodifica o la verifica del token di accesso
            Log::error('Error: ' . $e->getMessage());
            return response()->json([
                "message" => "Not authorized"
            ], 401);
        }

    }

    private function authenticate(AccessToken $accessToken)
    {
        $user = Cache::create($accessToken->value())->get();
        UserService::setUserCache($user);
        UserService::setTokenCache($accessToken);

    }
}

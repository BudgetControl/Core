<?php

namespace App\User\Middleware;

use App\User\Models\PersonalAccessToken;
use App\User\Services\UserService;
use App\User\Models\User;
use Illuminate\Support\Facades\Log;

class JwtAuthenticate
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

        $headers = $request->headers;
        $XACCESSTOKEN = $headers->get('X-ACCESS-TOKEN');

        if(env("APP_DISABLE_AUTH",false) === false) {
            if(empty($XACCESSTOKEN)) {
                Log::debug("token: ".json_decode($headers));
                abort(response()->json(['error' => 'no access token'], 401));
            }
    
            $token = PersonalAccessToken::findToken($XACCESSTOKEN);
            if(empty($token)) {
                abort(response()->json(['error' => 'not authorized'], 401));
            }
    
            UserService::setUserCache(User::find($token->tokenable_id));
        }

        return $next($request);

    }

}

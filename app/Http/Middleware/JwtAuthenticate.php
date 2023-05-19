<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Models\PersonalAccessToken;

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

        if(empty($headers->get('access_token'))) {
            abort(response()->json(['error' => 'no access token'], 401));
        }

        $token = PersonalAccessToken::findToken($headers->get('access_token'));
        if(empty($token)) {
            abort(response()->json(['error' => 'not authorized'], 401));
        }

        return $next($request);

    }

}

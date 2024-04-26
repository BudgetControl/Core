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
        $token = $request->header('X-BC-Token');
        if(empty($token)) {
            return response('Unauthorized', 401);
        }
        $jwtToken = JwtToken::decodeToken($token);
        $sub = $jwtToken['sub'];
        $user = User::where('sub',$sub)->first();
        UserService::setUserCache($user, $this->getActiveWorkspace($jwtToken['workspaces']));

        if(empty($user)) {
            return response('Unauthorized', 401);
        }

        return $next($request);

    }

    private function getActiveWorkspace($workspaces)
    {
        $activeWorkspace = null;
        foreach($workspaces as $workspace) {
            if($workspace->active === 1 ) {
                $activeWorkspace = $workspace->workspace_id;
                break;
            }
        }
        
        return $activeWorkspace;
    }

}

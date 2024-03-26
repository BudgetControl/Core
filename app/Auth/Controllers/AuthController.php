<?php

namespace App\Auth\Controllers;

use App\User\Models\User;
use App\Auth\Entity\JwtToken;
use Illuminate\Http\JsonResponse;
use App\User\Services\UserService;
use App\Auth\Exception\AuthException;
use App\Auth\Entity\Cognito\AccessToken;
use App\Auth\Entity\Cognito\CognitoToken;
use App\Auth\Service\ProviderClientService;
use App\BudgetTracker\Entity\Cache;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController
{
    use Encryptable;
    /**
     * googleAuthUrl
     *
     * @return JsonResponse
     */
    public function googleAuthUrl($provider): JsonResponse
    {
        try {
            $uri = ProviderClientService::init($provider)->url();
        } catch(AuthException $e){
            return response()->json(
                [
                    'success' => false,
                    'error' => $e->getMessage()
                ],
                401
            );
        }

        return response()->json([
            'success' => true,
            'uri' => $uri
        ]);

    }

    /**
     * signIn
     *
     * @param  string $code
     * @return RespoJsonResponsense
     */
    public function providerSignIn(string $code): JsonResponse
    {
        $response = ProviderClientService::get_token($code);
        $token = $this->authenticateUserCognito($response);

        //redirect to FE
        return response()->json([
            'success' => true,
            'access_token' => $token->value()
        ]);
    }

    /**
     * 
     */
    protected function authenticateUserCognito(CognitoToken $tokens): AccessToken
    {
        /** @var \App\Auth\Entity\Cognito\AccessToken $token */
        $token = $tokens->getToken(CognitoToken::ACCESS);
        /** @var \App\Auth\Entity\Cognito\IdToken $idToken */
        $idToken = $tokens->getToken(CognitoToken::ID);
        //save all informations in cache

        $jwt = new JwtToken();
        $idToken = $jwt->decode($idToken->value(),0);

        try {
            $user = User::where([
                'email' =>  Encryptable::encrypt(['email' => $idToken['email']])
            ])->firstOrFail();
            $user->sub = $idToken['sub'];
            $user->save();
        } catch(ModelNotFoundException $e) {
            //register user becouse is not founded in the database
            $user = new User();
            $user->email = $idToken['email'];
            $user->password= sha1($idToken['cognito:username']);
            $user->sub = $idToken['sub'];
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();
        }

        UserService::setUserCache($user);
        Cache::create($token->value())->set($user, Cache::TTL_FOREVER);

        return $token;
    }
}

<?php
namespace App\Auth\Controllers;

use App\Auth\Entity\Cognito\CognitoToken;
use App\Auth\Service\CognitoClientService;
use App\Auth\Service\GoogleClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController {
    
    /**
     * googleAuthUrl
     *
     * @return JsonResponse
     */
    public function googleAuthUrl(): JsonResponse
    {
        echo GoogleClientService::init()->url(); die;
    }
    
    /**
     * signIn
     *
     * @param  string $code
     * @return RespoJsonResponsense
     */
    public function signIn(string $code): JsonResponse
    {
        $token = CognitoClientService::init('')->getToken($code);

        return response()->json([
            'success' => true,
            'access_token' => $token->getToken(CognitoToken::ACCESS)->value()
        ]);

    }

}
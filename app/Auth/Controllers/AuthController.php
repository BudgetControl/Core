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
        $uri = GoogleClientService::init()->url();

        return response()->json(
            [
                'success' => true,
                'uri' => $uri
            ],
            301
        );
    }
    
    /**
     * signIn
     *
     * @param  string $code
     * @return RespoJsonResponsense
     */
    public function signIn(string $code): JsonResponse
    {
        $response = GoogleClientService::get_token($code);
        $response = $response->getBody();
        $content = json_decode($response->getContents());

        //redirect to FE
        return response()->json([
            'success' => true,
            $content
        ]);

    }

}
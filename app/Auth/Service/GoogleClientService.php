<?php

namespace App\Auth\Service;

use GuzzleHttp\Client;
use Aws\Credentials\Credentials;
use Aws\CognitoIdentity\CognitoIdentityClient;

class GoogleClientService
{

    private array $googleParams;

    private function __construct()
    {
        $googleParams = [
            'client_id' => config('cognito.app_client_id'),
            'redirect_uri' => config('cognito.google.redirect_url'),
            'response_type' => 'code',
            'scope' => 'email profile openid aws.cognito.signin.user.admin',
            'identity_provider' => 'Google',
            'state' => uniqid(),
        ];
        $this->googleParams = $googleParams;
    }

    /**
     * init
     *
     * @return GoogleClientService
     */
    public static function init(): GoogleClientService
    {
        return new GoogleClientService();
    }

    /**
     * url
     *
     * @return string
     */
    public function url(): string
    {
        $googleAuthorizationUrl = config('cognito.google.auth_url');
        $googleAuthUrl = $googleAuthorizationUrl . '?' . http_build_query($this->googleParams);
        return $googleAuthUrl;
    }

    public static function get_token(string $code)
    {

        $data = array(
            'code' => $code,
            'client_id' => config('cognito.app_client_id'),
            'client_secret' => config('cognito.app_client_secret'),
            'grant_type' => 'authorization_code',
            'scope' => 'email profile openid offline_access aws.cognito.signin.user.admin',
            'redirect_uri' => config('cognito.google.redirect_url')
        );

        $path = '/oauth2/token' . '?' . http_build_query($data);
        $client = new Client([
            'base_uri' => 'https://budgetcontrol.auth.eu-west-1.amazoncognito.com',
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ]
        ]);

        $response = $client->request('POST', $path, $data);
        return $response;

    }

}

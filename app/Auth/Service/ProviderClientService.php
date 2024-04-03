<?php

namespace App\Auth\Service;

use App\Auth\Exception\AuthException;
use GuzzleHttp\Client;
use Throwable;
use Illuminate\Support\Facades\Log;

class ProviderClientService
{

    private array $googleParams;

    const ALLOWED_PROVIDER = [
        'Google'
    ];

    private function __construct(string $provider)
    {
        if (!in_array($provider, self::ALLOWED_PROVIDER)) {
            throw new AuthException("$provider is not allowed");
        }

        $googleParams = [
            'client_id' => config('cognito.app_client_id'),
            'redirect_uri' => config('cognito.google.redirect_url'),
            'response_type' => 'code',
            'scope' => 'email profile openid aws.cognito.signin.user.admin',
            'identity_provider' => $provider,
            'state' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        ];
        $this->googleParams = $googleParams;
    }

    /**
     * init
     *
     * @return GoogleClientService
     */
    public static function init(string $provider): ProviderClientService
    {
        return new ProviderClientService($provider);
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
            'scope' => 'email profile openid',
            'redirect_uri' => config('cognito.google.redirect_url')
        );

        $path = '/oauth2/token' . '?' . http_build_query($data);
        try {
            $client = new Client([
                'base_uri' => 'https://budgetcontrol.auth.eu-west-1.amazoncognito.com',
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ]
            ]);

            $response = $client->request('POST', $path, $data);
            $response = $response->getBody();
            $content = json_decode($response->getContents());
            
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw new AuthException("An error occuring getting token", 401);
        }



        return CognitoClientService::saveTokens($content->id_token, $content->access_token, $content->refresh_token);
    }
}

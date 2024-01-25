<?php
namespace App\Auth\Service;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Ellaisys\Cognito\AwsCognitoClient;

class CognitoClientService {

    public AwsCognitoClient $client;

    private function __construct()
    {
        $options = [ 
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'region' => env('AWS_COGNITO_REGION'),
            'version' => env('AWS_COGNITO_VERSION'),
        ];

        $this->client = new AwsCognitoClient(
            new CognitoIdentityProviderClient($options),
            env("AWS_COGNITO_CLIENT_ID"),
            env("AWS_COGNITO_CLIENT_SECRET"),
            env("AWS_COGNITO_USER_POOL_ID"),
            env("AWS_COGNITO_USER_POOL_SECRET")
        );
    }

    public static function init(): CognitoClientService
    {
        return new CognitoClientService();
    }
}
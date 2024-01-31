<?php

namespace App\Auth\Service;

use App\BudgetTracker\Entity\Cache;
use App\Auth\Entity\Cognito\IdToken;
use Ellaisys\Cognito\AwsCognitoClient;
use App\Auth\Entity\Cognito\AccessToken;
use App\Auth\Entity\Cognito\CognitoToken;
use App\Auth\Entity\Cognito\RefreshToken;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\Result;
use Throwable;

class CognitoClientService
{

    public AwsCognitoClient $client;
    public CognitoIdentityProviderClient $clientProvider;
    private string $username;

    private function __construct(string $username)
    {
        $this->username = $username;

        $options = [
            'credentials' => [
                'key' => config('cognito.credentials.key'),
                'secret' => config('cognito.credentials.secret'),
            ],
            'region' => config('cognito.region'),
            'version' => config('cognito.version'),
        ];

        $this->clientProvider = new CognitoIdentityProviderClient($options);

        $this->client = new AwsCognitoClient(
            $this->clientProvider,
            config('cognito.app_client_id'),
            config('cognito.app_client_secret'),
            config('cognito.user_pool_id'),
            config('cognito.app_client_secret_allow')
        );
    }

    public static function init(string $username): CognitoClientService
    {
        return new CognitoClientService($username);
    }

    public function verifyUserEmail()
    {

        $attributes = [
            'email_verified' => 'true',
        ];

        $this->client->setUserAttributes($this->username, $attributes);

        return $this;
    }

    /**
     * forceUserPassword
     *
     * @param  mixed $username
     * @param  mixed $password
     * @return void
     */
    public function forceUserPassword(string $password): self
    {
        $this->client->setUserPassword($this->username, $password, true);

        return $this;
    }

    /**
     * saveTokens
     *
     * @param  mixed $awsResult
     * @return CognitoToken
     */
    private function saveTokens(Result $awsResult): CognitoToken
    {
        $idToken = $awsResult->get('AuthenticationResult')['IdToken'];
        $accessToken = $awsResult->get('AuthenticationResult')['AccessToken'];
        $refreshToken = $awsResult->get('AuthenticationResult')['RefreshToken'];

        $tokens = new CognitoToken();
        $tokens->setToken(IdToken::set($idToken), CognitoToken::ID);
        $tokens->setToken(AccessToken::set($accessToken), CognitoToken::ACCESS);
        $tokens->setToken(RefreshToken::set($refreshToken), CognitoToken::REFRESH);
        Cache::create($accessToken . 'refresh_token')->set(RefreshToken::set($refreshToken), 7200);

        return $tokens;
    }

    /**
     * authLogin
     *
     * @param  mixed $password
     * @return CognitoToken
     */
    public function authLogin(string $password): CognitoToken
    {
        $result = $this->client->authenticate($this->username, $password);
        return $this->saveTokens($result);
    }

    /**
     * refresh
     *
     * @param  mixed $token
     * @return CognitoToken
     */
    public function refresh(string $token): CognitoToken
    {
        $result = $this->client->refreshToken($this->username, $token);
        return $this->saveTokens($result);
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $this->client->deleteUser($this->username);
    }


    /**
     * getToken
     *
     * @param  mixed $code
     * @return CognitoToken
     */
    public function getToken(string $code): CognitoToken
    {
        $tokenParams = [
            'client_id' => 'tuo_client_id_cognito',
            'client_secret' => 'tuo_client_secret_cognito',
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'https://tuo-sito.com/redirect-uri',
        ];

        $result = $this->clientProvider->getToken($tokenParams);

        return $this->saveTokens($result);
 
    }
}

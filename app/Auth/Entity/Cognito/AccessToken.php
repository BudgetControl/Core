<?php 
namespace App\Auth\Entity\Cognito;

use App\Auth\Entity\Cognito\CognitoToken;

class AccessToken implements CongitoTokenInterface {

    public string $value;

    private function __construct(string $token)
    {
        $this->value = $token;
    }

    public static function set(string $token): AccessToken
    {
        return new AccessToken($token);
    }

    /**
     * Get the value of accessToken
     *
     * @array string
     */
    public function getAccessToken(): array
    {
        return [CognitoToken::ACCESS => $this->value];
    }

    /**
     * Get the value of value
     *
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }
}
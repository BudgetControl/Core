<?php 
namespace App\Auth\Entity\Cognito;

use App\Auth\Entity\Cognito\CognitoToken;

class RefreshToken implements CongitoTokenInterface {

    private string $value;

    private function __construct(string $token)
    {
        $this->value = $token;
    }

    public static function set(string $token): RefreshToken
    {
        return new RefreshToken($token);
    }

    /**
     * Get the value of accessToken
     *
     * @array string
     */
    public function getRefreshToken(): array
    {
        return [CognitoToken::REFRESH => $this->value];
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
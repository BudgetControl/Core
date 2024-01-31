<?php 
namespace App\Auth\Entity\Cognito;

use App\Auth\Entity\Cognito\CognitoToken;

class IdToken implements CongitoTokenInterface {

    private string $value;

    private function __construct(string $token)
    {
        $this->value = $token;
    }

    public static function set(string $token): IdToken
    {
        return new IdToken($token);
    }

    /**
     * Get the value of accessToken
     *
     * @array string
     */
    public function getIdToken(): array
    {
        return [CognitoToken::ID => $this->value];
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
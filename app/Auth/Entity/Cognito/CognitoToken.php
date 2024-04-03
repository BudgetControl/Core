<?php
namespace App\Auth\Entity\Cognito;

use App\Auth\Entity\Cognito\CongitoTokenInterface;
use DateTime;

final class CognitoToken {

    const REFRESH = 'RefreshToken';
    const ACCESS = 'AccessToken';
    const ID = 'IdToken';

    private DateTime $datetime;
    private array $tokens;

    private CongitoTokenInterface $token;

    public function __construct()
    {
        $this->datetime = new DateTime();
    }

    /**
     * Get the value of token
     *
     * @return CognitoTokenInterface
     */
    public function getToken(string $type): CongitoTokenInterface
    {
        return $this->tokens[$type];
    }

    /**
     * Get the value of token
     *
     * @return CognitoTokenInterface
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }


    /**
     * Get the value of datetime
     *
     * @return DateTime
     */
    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }


    /**
     * Set the value of tokens
     *
     * @param array $tokens
     *
     * @return self
     */
    public function setToken(CongitoTokenInterface $token, string $type): self
    {
        $this->tokens[$type] = $token;

        return $this;
    }
}
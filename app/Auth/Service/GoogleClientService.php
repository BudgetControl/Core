<?php
namespace App\Auth\Service;

class GoogleClientService {

    private array $googleParams;

    private function __construct()
    {
        $googleParams = [
            'client_id' => config('cognito.google.client_id'),
            'redirect_uri' => config('cognito.google.redirect_url'),
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'state' => 'stato_random',
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
}
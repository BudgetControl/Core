<?php

namespace App\Auth\Entity;

use App\Auth\Exception\AuthException;
use App\BudgetTracker\Entity\Cache;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Illuminate\Support\Facades\Log;

/**
 * @ Author: Your name
 * @ Create Time: 2024-01-27 19:11:57
 * @ Modified by: Your name
 * @ Modified time: 2024-01-27 19:12:15
 * @ Description:
 */

final class JwtToken
{
    const ACCESS_TOKEN = 1;
    const REFRESH_TOKEN = 0;

    private object $pk;

    public function __construct()
    {
	JWT::$leeway = 60;
        $this->getPublicKey();
    }

    /**
     * get public key
     */
    private function getPublicKey()
    {
        if($pk = Cache::create(config("app.key").'cognito_public_key')->get()) {
            $this->pk = $pk;
        } else {
            $pk = json_decode(
                file_get_contents('https://cognito-idp.' . config('cognito.region') . '.amazonaws.com/' . config('cognito.user_pool_id') . '/.well-known/jwks.json')
            );
            Cache::create(config("app.key").'cognito_public_key')->set($pk,604800);
            $this->pk = $pk;
        }
    }

    /**
     *  convert JWK to pem key
     *  @param array $pK
     * 
     *  @return Key
     */
    private function jwkToPem(array $key): Key
    {
        return JWK::parseKey($key, 'RS256');
    }

    /**
     * decode a JWT cognito token
     */
    public function decode(string $jwt_json, int $type = self::ACCESS_TOKEN): array
    {
        $keys = $this->pk;
        try {
            $pk = $this->jwkToPem((array) $keys->keys[1]);

            $pay_load = JWT::decode($jwt_json, $pk);

            if ($pay_load !== '') {
                return  get_object_vars($pay_load);
            }
        } catch (\Exception $e) {
            Log::critical($e->getMessage());
            throw new AuthException("Unable to decode $type token ");
        }
    }
    

}

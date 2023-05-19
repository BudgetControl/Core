<?php

namespace App\Traits;

use Firebase\JWT\Key;
use Firebase\JWT\JWT;

trait Encryptable
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        if (isset($this->encryptable) && in_array($key, $this->encryptable) && (!is_null($value))) {
            $value = $this->decrypt($value);
        }

        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (isset($this->encryptable) && in_array($key, $this->encryptable) && (!is_null($value))) {

            $JWT_PAYLOAD = [
                $key => $value
            ];

            $value = $this->encrypt($JWT_PAYLOAD);

        }

        return parent::setAttribute($key, $value);
    }

    /**
     * decrypt s specific data
     * @param string $JWT
     */
    public static function decrypt(string $JWT)
    {
        return JWT::decode($JWT, new Key(env('JWT_SECRET','no_secret'), 'HS256'));
    }

    /**
     * encrypt s specific data
     * @param array $JWT_PAYLOAD
     */
    public static function encrypt(array $JWT_PAYLOAD)
    {
        return JWT::encode($JWT_PAYLOAD, env('JWT_SECRET','no_secret'), 'HS256');
    }
}

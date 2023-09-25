<?php

namespace App\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use App\User\Models\PersonalAccessToken;
use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Encryptable, SoftDeletes;

    public $link;

    /**
     *  encryptable data
     */

     protected $encryptable = [
        'email'
    ];

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @param  string $jwtToken
     * @param  \DateTimeInterface|null  $expiresAt
     * @return NewAccessToken
     */
    public function createToken(string $name, $jwtToken, array $abilities = ['*'], \DateTimeInterface $expiresAt = null): NewAccessToken
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => $jwtToken,
            'abilities' => $abilities,
            'expires_at' => $expiresAt,
        ]);

        return new NewAccessToken($token, $jwtToken);
    }

    /**
     * Retrive not expired token
     *
     * @return NewAccessToken|bool
     */
    public function retriveNotExpiredToken(): NewAccessToken|bool
    {
        $token = PersonalAccessToken::where('tokenable_id',$this->id)
        ->where('name','access_token')->where('expires_at','>',date('Y-m-d H:i:s',time()))->get();
        
        if(empty($token[0])) {
            return false;
        }

        return new NewAccessToken($token[0], $token[0]->token);
    }

    /**
     * set up last usage token
     */
    public function useToken(): void
    {
        PersonalAccessToken::where('tokenable_id',$this->id)
        ->where('name','access_token')->where('expires_at','>',date('Y-m-d H:i:s',time()))->update(
            [ 'last_used_at' => date('Y-m-d H:i:s',time())]
        );
    }
}

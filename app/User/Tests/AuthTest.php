<?php

namespace Tests\Feature;

use App\Auth\Service\CognitoClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    const PAYLOAD = [
        "password" => "02847dheYdj@Os8",
        "password_confirmation" => "f02847dheYdj@Os8",
        "email" => "foo@email.it",
        "name" => "foo bar",
        "rememberMe" => 'false'
    ];

    public function test_fake()
    {
        $true = true;
        $this->assertTrue($true);
    }

    // /**
    //  * A basic feature test example.
    //  */
    // public function test_registration(): void
    // {
    //     $payload = self::PAYLOAD;
    //     $payload['email'] = 'foo_bar@email.it';

    //     $response = $this->post('/auth/register', $payload);

    //     $response->assertStatus(200);

    // }

    // /**
    //  * A basic feature test example.
    //  */
    // public function test_login(): void
    // {
    //     $payload = self::PAYLOAD;
    //     $payload['email'] = 'foo_bar@email.it';

    //     $response = $this->post('/auth/authenticate', $payload);

    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'success','access_token'
    //     ]);
    // }

    // /**
    //  * A basic feature test example.
    //  */
    // public function test_authentication_fail(): void
    // {
    //     $payload = self::PAYLOAD;
    //     $payload['email'] = 'nomail@email.it';

    //     $response = $this->post('/auth/authenticate', $payload);

    //     $response->assertStatus(401);
    // }

    // /**
    //  * A basic feature test example.
    //  */
    // public function test_delete_user(): void
    // {
    //     CognitoClientService::init('foo_bar@email.it')->delete();
    //     $true = true;

    //     $this->assertTrue($true);

    // }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    const PAYLOAD = [
        "password" => "password",
        "confirmed_password" => "foo@email.it",
        "email" => "foo@email.it",
        "name" => "foo bar"
    ];

    const TOKEN = [
        "token" => [
            "accessToken" => [
                "name",
                "abilities",
                "expires_at",
                "tokenable_id",
                "tokenable_type",
                "updated_at",
                "created_at",
                "id"
            ],
            "plainTextToken"
        ]
    ];

    /**
     * A basic feature test example.
     */
    public function test_registration(): void
    {
        $payload = self::PAYLOAD;
        $payload['email'] = 'register@email.it';

        $response = $this->post('/auth/register', $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure(self::TOKEN);
    }

    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $response = $this->post('/auth/login', self::PAYLOAD);

        $response->assertStatus(200);
        $response->assertJsonStructure(self::TOKEN);
    }

    /**
     * A basic feature test example.
     */
    public function test_authentication(): void
    {
        $response = $this->post('/auth/authenticate', self::PAYLOAD);

        $response->assertStatus(200);
        $response->assertJsonStructure(self::TOKEN);
    }

    /**
     * A basic feature test example.
     */
    public function test_authentication_fail(): void
    {
        $payload = self::PAYLOAD;
        $payload['email'] = 'nomail@email.it';

        $response = $this->post('/auth/authenticate', $payload);

        $response->assertStatus(401);
    }
}

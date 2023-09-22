<?php

namespace Tests\Feature;

use App\Http\Services\AuthService;
use Tests\TestCase;

class MailerTest extends TestCase
{
    const MAILER_API_PATH = "http://mailhog-service:8025/api/v1/messages";

    const PAYLOAD = [
        "password" => "password",
        "confirmed_password" => "foo@email.it",
        "email" => "foo@email.it",
        "name" => "foo bar"
    ];

    /**
     * A basic feature test example.
     */
    public function test_registration_mail(): void
    {
        $payload = self::PAYLOAD;
        $payload['email'] = 'register@email.it';

        $response = $this->post('/auth/register', $payload);

        $response = curl_get(self::MAILER_API_PATH);
        $body = $response[0]?->Content?->Body;
        
        $this->assertStringContainsString("foo bar", $body);
        $this->assertStringContainsString("Email Address: register@email.it", $body);
        $this->assertStringContainsString("Confirm Email", $body);

        $pattern = '/\/auth\/confirm\/[a-zA-Z0-9\/]+/';
        $this->assertMatchesRegularExpression($pattern, $body);

    }

    /**
     * A basic feature test example.
     */
    public function test_recovery_password_mail(): void
    {
        $response = $this->post('/auth/recovery', [
            "email" => "foo@email.it"
        ]);

        $response = curl_get(self::MAILER_API_PATH);
        $body = $response[0]?->Content?->Body;
        
        $this->assertStringContainsString("foo bar", $body);

        $pattern = '/\/auth\/reset-password\/[a-zA-Z0-9\/]+/';
        $this->assertMatchesRegularExpression($pattern, $body);
    }

}

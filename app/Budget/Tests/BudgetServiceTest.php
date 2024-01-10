<?php

namespace Tests\Feature;

use Tests\TestCase;

require_once 'app/User/Tests/AuthTest.php';

class BudgetServiceTest extends TestCase
{
    const BUDGET_RESPONSE = [
        [
            "uuid",
            "budget",
            "config",
            "amount",
            "percentage",
            "difference",
            "id",
            "notification"
        ]
    ];

    /**
     * A basic feature test example.
     */
    public function test_create_budget(): void
    {
        $response = $this->post('/api/budget/create', $this->payload(), $this->getAuthTokenHeader());

        $response->assertStatus(200);
    }

    public function test_stats_budget(): void
    {
        $response = $this->get('/api/budget/stats', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::BUDGET_RESPONSE);
    }

    public function test_budget_expired(): void
    {
        $response = $this->get('/api/budget/expired/1', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJson([
            "expired" => true
        ]);
    }

    private function payload()
    {
        return [
            "amount" => 100.00,
            "account" => [3, 4],
            "period" => "weekly",
            "name" => "test"
        ];
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];
    }
}

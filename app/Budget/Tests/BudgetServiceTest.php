<?php

namespace Tests\Feature;

use Tests\TestCase;

require_once 'app/User/Tests/AuthTest.php';

class BudgetServiceTest extends TestCase
{
    const BUDGET_RESPONSE = [
        "uuid",
        "name",
        "budget",
        "type",
        "planning",
        "amount"
    ];

    /**
     * A basic feature test example.
     */
    public function test_create_budget(): void
    {
        $response = $this->post('/api/budget/create', $this->payload(), $this->getAuthTokenHeader());

        $response->assertStatus(200);
    }

    public function test_stats_budgets(): void
    {
        $response = $this->get('/api/budget/stats/1', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJson([self::BUDGET_RESPONSE]);
    }

    public function test_stats_budget(): void
    {
        $response = $this->get('/api/budget/stats', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJson(self::BUDGET_RESPONSE);

    }

    public function test_budget_expired(): void
    {
        $response = $this->get('/api/budget/expired/1', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJson([
            "expired" => false
        ]);

    }

    private function payload()
    {
        return [
                "budget" => 100.00,
                "account" => [3,4],
                "planningType" => "weekly",
                "name" => "test"
        ];
    }
}

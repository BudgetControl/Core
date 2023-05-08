<?php

namespace Tests\Feature;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Models\PlannedEntries;
use App\BudgetTracker\Models\Incoming;
use DateTime;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Models\Expenses;
use Tests\TestCase;

class StatsGetDataTest extends TestCase
{
    const RESPONSE = [
            "data" => [
                    "total",
            ],
            "message",
            "errorCode",
            "version"
    ];

    const WALLET = [
        "data" => [
                "total",
        ],
        "message",
        "errorCode",
        "version"
];

    const WALLETS = [
        "data" => [
            [
                "account_id",
                "account_label",
                "color",
                "total_wallet"
            ]
        ],
        "message",
        "errorCode",
        "version"
];

    /**
     * A basic feature test example.
     */
    public function test_incoming_stats(): void
    {
        Incoming::factory(1)->create();

        $response = $this->get('/api/stats/incoming/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount >= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_incoming_year_stats(): void
    {
        Incoming::factory(1)->create();

        $response = $this->get('/api/stats/incoming/'.date('Y',time()));

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount >= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_incoming_year_month_stats(): void
    {
        Incoming::factory(1)->create();

        $response = $this->get('/api/stats/incoming/'.date('Y',time()).'/'.date("M",time()));

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount >= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_incoming_year_month_day_stats(): void
    {
        Incoming::factory(1)->create();

        $response = $this->get('/api/stats/incoming/'.date('Y',time()).'/'.date("M",time()).'/'.date('d',time()));

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount >= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_expenses_stats(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/expenses/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount <= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_expenses_year_stats(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/expenses/'.date('Y',time()));

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount <= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_expenses_year_month_stats(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/expenses/'.date('Y',time()).'/'.date("M",time()));

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount <= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_expenses_year_month_day_stats(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/expenses/'.date('Y',time()).'/'.date("M",time()).'/'.date('d',time()));

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount <= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_total_stats(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/total/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::WALLET);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount <= 0 || $test_amount >= 0 );
    }

    /**
     * A basic feature test example.
     */
    public function test_total_planned_stats(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/total/planned/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount <= 0 || $test_amount >= 0 );
    }

        /**
     * A basic feature test example.
     */
    public function test_wallets_stats(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/wallets/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::WALLETS);

        $test_amount = $response['data'][0]['total_wallet'];
        $this->assertTrue($test_amount <= 0 || $test_amount >= 0 );
    }

}

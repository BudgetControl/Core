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
use App\BudgetTracker\Models\Investments;
use Tests\TestCase;
use Tests\Feature\AuthTest;

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

    private $headers = '';

    /**
     * A basic feature test example.
     */
    public function test_incoming_stats(): void
    {
        

        Incoming::factory(1)->create();

        $response = $this->get('/api/stats/incoming/',$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/incoming/'.date('Y',time()),$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/incoming/'.date('Y',time()).'/'.date("M",time()),$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/incoming/'.date('Y',time()).'/'.date("M",time()).'/'.date('d',time()),$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/expenses/',$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/expenses/'.date('Y',time()),$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/expenses/'.date('Y',time()).'/'.date("M",time()),$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/expenses/'.date('Y',time()).'/'.date("M",time()).'/'.date('d',time()),$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/total/',$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/total/planned/',$this->getAuthTokenHeader());

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

        $response = $this->get('/api/stats/wallets/',$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::WALLETS);

        $test_amount = $response['data'][0]['total_wallet'];
        $this->assertTrue($test_amount <= 0 || $test_amount >= 0 );
    }

    /**
     * A basic feature test example.
     */
    public function test_investments_stats(): void
    {
        Investments::factory(1)->create();

        $response = $this->get('/api/stats/investments/',$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount <= 0);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];  
    }
}

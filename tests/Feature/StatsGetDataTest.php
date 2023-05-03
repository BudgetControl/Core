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

    /**
     * A basic feature test example.
     */
    public function test_incoming_data(): void
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
    public function test_incoming_year_data(): void
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
    public function test_incoming_year_month_data(): void
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
    public function test_incoming_year_month_day_data(): void
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
    public function test_expenses_data(): void
    {
        Expenses::factory(1)->create();

        $response = $this->get('/api/stats/expenses/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::RESPONSE);

        $test_amount = $response['data']['total'];
        $this->assertTrue($test_amount >= 0);
    }
}

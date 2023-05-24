<?php

namespace Tests\Feature;

use App\BudgetTracker\Enums\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    const PAYLOAD = [
        "name" => "bank account",
        "type" => "bank",
        "date_end" => "15",
        "color" =>  "bg-blueGray-200 text-blueGray-600"
    ];

    const STRUCTURE = [
            "data" => [
                [
                    "id",
                    "date_time",
                    "uuid",
                    "name",
                    "color",
                    "user_id"
                ]
            ],
        "message",
        "errorCode",
        "version"
    ];

    /**
     * A basic feature test example.
     */
    public function test_account_data(): void
    {
        $response = $this->get('/api/accounts/',$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::STRUCTURE);
    }

    /**
     * A basic feature test example.
     */
    public function test_account_insert(): void
    {
        $response = $this->post('/api/accounts/',self::PAYLOAD, $this->getAuthTokenHeader());

        $response->assertStatus(200);

        $this->assertDatabaseHas(Account::class,[
            'name' => "bank account",
            'type' => AccountType::Bank->value,
            'date_end' => 15,
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_account_update(): void
    {
        $response = $this->post('/api/accounts/',self::PAYLOAD, $this->getAuthTokenHeader());

        $update = self::PAYLOAD;
        $update['name'] = 'test';

        $response = $this->put('/api/accounts/',$update, $this->getAuthTokenHeader());

        $response->assertStatus(200);

        $this->assertDatabaseHas(Account::class,[
            'name' => "test",
            'type' => AccountType::Bank->value,
            'date_end' => 15,
        ]);
    }
    
    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['access_token' => $token];  
    }
}

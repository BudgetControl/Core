<?php

namespace Tests\Feature;

use App\BudgetTracker\Enums\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\BudgetTracker\Models\Account;

class AccountTest extends TestCase
{
    const PAYLOAD = [
        "name" => "bank account",
        "type" => "Bank",
        "color" =>  "#000123",
        "currency" => "EUR",
        "installement" => 0,
        "balance" => 0
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
        $response = $this->get('/api/accounts/', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::STRUCTURE);
    }

    /**
     * A basic feature test example.
     */
    public function test_account_bank_insert(): void
    {
        $response = $this->post('/api/accounts/', self::PAYLOAD, $this->getAuthTokenHeader());

        $response->assertStatus(200);

        $this->assertDatabaseHas(Account::class, [
            'name' => "bank account",
            'type' => AccountType::Bank->value,
        ]);
    }

        /**
     * A basic feature test example.
     */
    public function test_account_creditCard_insert(): void
    {
        $request = self::PAYLOAD;
        $request['installement'] = 1;
        $request['installementValue'] = 200.00;
        $request['date'] = '2023-06-12';
        $request['type'] = 'CreditCard';

        $response = $this->post('/api/accounts/', $request, $this->getAuthTokenHeader());

        $response->assertStatus(200);

        $this->assertDatabaseHas(Account::class, [
            'name' => "bank account",
            'type' => AccountType::CreditCard->value,
        ]);
    }

            /**
     * A basic feature test example.
     */
    public function test_account_saving_insert(): void
    {
        $request = self::PAYLOAD;
        $request['installement'] = 0;
        $request['amount'] = 200.00;
        $request['date'] = '2023-06-12';
        $request['type'] = 'Saving';

        $response = $this->post('/api/accounts/', $request, $this->getAuthTokenHeader());

        $response->assertStatus(200);

        $this->assertDatabaseHas(Account::class, [
            'name' => "bank account",
            'type' => AccountType::Saving->value,
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_account_update(): void
    {
        $response = $this->post('/api/accounts/', self::PAYLOAD, $this->getAuthTokenHeader());

        $update = self::PAYLOAD;
        $update['name'] = 'test';
        $update['balance'] = '1024';

        $response = $this->post('/api/accounts/', $update, $this->getAuthTokenHeader());

        $response->assertStatus(200);

        $this->assertDatabaseHas(Account::class, [
            'name' => "test",
            'type' => AccountType::Bank->value,
            'user_id' => 1,
            'balance' => 1024
        ]);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];
    }
}

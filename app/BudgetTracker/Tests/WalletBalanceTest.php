<?php

namespace App\BudgetTracker\Tests;

use Tests\TestCase;
use \DateTime;
use App\BudgetTracker\Models\Account;

class WalletBalanceTest extends TestCase
{

    const PAYLOAD = [
        "password" => "password",
        "confirmed_password" => "foo@email.it",
        "email" => "foo@email.it",
        "name" => "foo bar"
    ];

    /**
     * A basic feature test example.
     */
    public function test_add_incoming_balance_data(): void
    {
        $this->initBalance();

        $payload = $this->makeRequest(700,new DateTime("-1 day"));

        $response = $this->postJson(
            "api/incoming",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);

        $except = [
            "balance" => 5700,
            "id" => 5
        ];

        $this->assertDatabaseHas("accounts",$except);
    }

    /**
     * A basic feature test example.
     */
    public function test_add_expenses_balance_data(): void
    {
        $payload = $this->makeRequest(-1000,new DateTime("-1 day"));

        $response = $this->postJson(
            "api/expenses",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);

        $except = [
            "balance" => 4700,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);
    }

    /**
     * A basic feature test example.
     */
    public function test_add_debit_balance_data(): void
    {
        $payload = $this->makeRequest(-1500,new DateTime("-1 day"));
        $payload['payee_id'] = "Pippo";

        $response = $this->postJson(
            "api/debit",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);

        $except = [
            "balance" => 3200,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_planned_balance_data(): void
    {
        $payload = $this->makeRequest(50,new DateTime("+2 day"));

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "balance" => 3200,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);

    }

    public function test_update_planned_balance_v2_data(): void
    {
        $payload = $this->makeRequest(1000,new DateTime("-2 day"));

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "balance" => 4150,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);

    }

    /**
     * A basic feature test example.
     */
    public function test_update_confirmed_balance_data(): void
    {
        $payload = $this->makeRequest(7000,new DateTime("-2 day"));
        $payload['confirmed'] = false;

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "balance" => 4150.00,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_confirmed_balance_v2_data(): void
    {
        $payload = $this->makeRequest(70,new DateTime("-2 day"));
        $payload['confirmed'] = true;

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "balance" => -2780.00,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_incoming_expenses_balance_data(): void
    {
        $payload = $this->makeRequest(-700,new DateTime("-1 day"));
        
        $response = $this->putJson(
            "api/expenses/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "balance" => -3480.00,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);

    }

    /**
     * A basic feature test example.
     */
    public function test_add_transfer_balance_data(): void
    {
        $payload = $this->makeRequest(300,new DateTime("-1 day"));
        $payload['transfer_id'] = "6";

        $response = $this->postJson(
            "api/transfer",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);

        $except = [
            "balance" => -4850.00,
            "id" => 5
        ];
        $this->assertDatabaseHas("accounts",$except);

        $except = [
            "balance" => 300,
            "id" => 6
        ];
        $this->assertDatabaseHas("accounts",$except);

    }

    /**
     * build model request
     * @param float $amount
     * @param DateTime $dateTime
     * 
     * @return array
     */
    private function makeRequest(float $amount, DateTime $dateTime): array
    {

        $request = '{ 
            "amount": '.$amount.',
            "note" : "test",
            "category_id":12,
            "account_id" : 5,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "'.$dateTime->format('Y-m-d H:i:s').'",
            "label": [],
            "waranty": 1,
            "confirmed": 1
        }';

        return (array) json_decode($request,true);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', self::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];
    }

    private function initBalance()
    {
        $account = Account::where('id',5)->firstOrFail();
        $account->balance = 5000;
        $account->save();
    }
}

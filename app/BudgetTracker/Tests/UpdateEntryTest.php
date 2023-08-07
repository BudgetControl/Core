<?php

namespace App\BudgetTracker\Tests;

use Tests\TestCase;
use \DateTime;

class UpdateEntryTest extends TestCase
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
    public function test_update_expenses_data(): void
    {
        $payload = $this->makeRequest(-500,new DateTime());

        $response = $this->putJson(
            "api/expenses/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "amount" => -500,
            "uuid" => "64b54cc566d77_test",
            "type" => "expenses",
            "planned" => 0
        ];

        $this->assertDatabaseHas("entries",$except);

    }

    /**
     * A basic feature test example.
     */
    public function test_update_incoming_data(): void
    {
        $payload = $this->makeRequest(500,new DateTime());

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "amount" => 500,
            "uuid" => "64b54cc566d77_test",
            "type" => "incoming",
            "planned" => 0
        ];

        $this->assertDatabaseHas("entries",$except);

    }

    /**
     * A basic feature test example.
     */
    public function test_update_planned_data(): void
    {
        $payload = $this->makeRequest(500,new DateTime("+1 month"));

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "amount" => 500,
            "uuid" => "64b54cc566d77_test",
            "type" => "incoming",
            "planned" => 1
        ];

        $this->assertDatabaseHas("entries",$except);

    }

    /**
     * A basic feature test example.
     */
    public function test_update_confirmed_data(): void
    {
        $payload = $this->makeRequest(500,new DateTime());
        $payload['confirmed'] = false;

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "amount" => 500,
            "uuid" => "64b54cc566d77_test",
            "type" => "incoming",
            "confirmed" => 0,
            "planned" => 0
        ];

        $this->assertDatabaseHas("entries",$except);

    }

    /**
     * A basic feature test example.
     */
    public function test_update_note_data(): void
    {
        $payload = $this->makeRequest(500,new DateTime());
        $payload['note'] = "test note";

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $except = [
            "amount" => 500,
            "uuid" => "64b54cc566d77_test",
            "type" => "incoming",
            "note" => "test note",
            "planned" => 0
        ];

        $this->assertDatabaseHas("entries",$except);

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
            "account_id" : 1,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "'.$dateTime->format('Y-m-d H:i:s').'", 
            "label": [],
            "user_id": 1,
            "waranty": 1,
            "confirmed": 1,
            "user_id": 1
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
}

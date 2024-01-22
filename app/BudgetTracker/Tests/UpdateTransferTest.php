<?php

namespace App\BudgetTracker\Tests;

use Tests\TestCase;
use \DateTime;

class UpdateTransferTest extends TestCase
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
    public function test_update_transfer_data(): void
    {
        $payload = $this->makeRequest(500,new DateTime());

        $response = $this->putJson(
            "api/transfer/64b54d02cdcfd_test",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas("entries",[
            "amount" => -500,
            "uuid" => "64b54d02cdcfd_test",
            "type" => "transfer",
            "planned" => 0,
            "transfer_id" => 2,
            "account_id" => 1
        ]);

        $this->assertDatabaseHas("entries",[
            "amount" => 500,
            "uuid" => "64b54d02cdcft_test",
            "type" => "transfer",
            "planned" => 0,
            "transfer_id" => 1,
            "account_id" => 2
        ]);

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
            "waranty": 1,
            "confirmed": 1,
            "transfer_id":2,
            "transfer_relation":"64b54d02cdcft_test"
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

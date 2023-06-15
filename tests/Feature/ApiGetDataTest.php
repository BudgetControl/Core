<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiGetDataTest extends TestCase
{
    const ENTRY = [
        "data" => [
            "id",
            "uuid",
            "amount",
            "note",
            "type",
            "waranty",
            "transfer",
            "confirmed",
            "planned",
            "category_id",
            "model_id",
            "account_id",
            "transfer_id",
            "currency_id",
            "payment_type",
            "payee_id",
            "geolocation",
            "label",
            "sub_category" => [
                "id",
                "date_time",
                "uuid",
                "name",
                "category_id",
                "category" => [
                    "id",
                    "date_time",
                    "uuid",
                    "name",
                    "icon"
                ]
            ],
            "account" => [
                "id",
                "uuid",
                "name",
                "color"
            ],
            "geolocation"
        ],
        "message",
        "errorCode",
        "version"
    ];

    const PLANNING = [
        "data" => [
            "id",
            "uuid",
            "amount",
            "note",
            "type",
            "waranty",
            "transfer",
            "confirmed",
            "planned",
            "category_id",
            "model_id",
            "account_id",
            "transfer_id",
            "currency_id",
            "payment_type",
            "payee_id",
            "geolocation_id",
        ],
        "message",
        "errorCode",
        "version"
    ];

    const PAYEE = [
        "data" => [
            [
                "id",
                "uuid",
                "name",
                "date_time"
            ]
        ]
    ];

    const INCOMING_ID = 1;
    const EXPENSES_ID = 1012;
    const DEBIT_ID = 2001;
    const TRANSFER_ID = 2002;
    const PLANNING_RECURSIVELY = 1;

    private $headers = '';

    
    /**
     * A basic feature test example.
     */
    public function test_incoming_data(): void
    {
        $response = $this->get('/api/incoming/' . self::INCOMING_ID,$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $test_amount = $response['data']['amount'];
        $this->assertTrue($test_amount >= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_expenses_data(): void
    {
        $response = $this->get('/api/expenses/' . self::EXPENSES_ID,$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $test_amount = $response['data']['amount'];
        $this->assertTrue($test_amount <= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_debit_data(): void
    {
        $response = $this->get('/api/debit/' . self::DEBIT_ID,$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $test_payee = $response['data']['payee_id'];
        $this->assertTrue(!empty($test_payee));
    }


    /**
     * A basic feature test example.
     */
    public function test_transfer_data(): void
    {
        $response = $this->get('/api/transfer/' . self::TRANSFER_ID,$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $test_transfer_id = $response['data']['transfer_id'];
        $test_coount_id = $response['data']['account_id'];
        $this->assertTrue(!empty($test_transfer_id));
        $this->assertTrue($test_coount_id != $test_transfer_id);
    }

    /**
     * A basic feature test example.
     */
    public function test_planning_recursively_data(): void
    {
        $response = $this->get('/api/planning-recursively/' . self::PLANNING_RECURSIVELY,$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::PLANNING);
    }

    /**
     * A basic feature test example.
     */
    public function test_payees_data(): void
    {
        $response = $this->get('/api/payee/',$this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::PAYEE);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['access_token' => $token];  
    }
}

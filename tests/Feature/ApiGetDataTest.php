<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Feature\AuthTest;

class ApiGetDataTest extends TestCase
{
    const ENTRIES = [
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
    ];

    const ENTRY = ["data" => self::ENTRIES];

    const PLANNING = [
            ["uuid",
            "type",
            "date_time",
            "amount",
            "note",
            "waranty",
            "transfer",
            "confirmed",
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
                "date_time",
                "uuid",
                "name",
                "color",
                "user_id",
                "date",
                "type",
                "installement",
                "installementValue",
                "currency",
                "amount",
                "balance"
            ],
            "currency_id",
            "payment_type",
            "planning",
            "end_date_time",]
    ];

    const PAYEE = [
        [
            "date_time",
            "entry",
            "id",
            "name",
            "user_id",
            "uuid"
        ]
    ];

    const INCOMING_ID = '64b54cc566d77_test';
    const EXPENSES_ID = '64b54cc5677e0_test';
    const DEBIT_ID = '64b54cc568334_test';
    const TRANSFER_ID = '64b54d02cdcfd_test';
    const PLANNING_RECURSIVELY = '64b54cc56942d_test';

    public function get_all_incoming_data(): void
    {
        $response = $this->get('/api/incoming/', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $test_amount = $response['data']['amount'];
        $this->assertTrue($test_amount >= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_incoming_data(): void
    {
        $response = $this->get('/api/incoming/' . self::INCOMING_ID, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRIES);

        $test_amount = $response['amount'];
        $this->assertTrue($test_amount >= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_expenses_data(): void
    {
        $response = $this->get('/api/expenses/' . self::EXPENSES_ID, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRIES);

        $test_amount = $response['amount'];
        $this->assertTrue($test_amount <= 0);
    }

    /**
     * A basic feature test example.
     */
    public function test_debit_data(): void
    {
        $response = $this->get('/api/debit/' . self::DEBIT_ID, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRIES);

        $test_payee = $response['payee_id'];
        $this->assertTrue(!empty($test_payee));
    }


    /**
     * A basic feature test example.
     */
    public function test_transfer_data(): void
    {
        $response = $this->get('/api/transfer/' . self::TRANSFER_ID, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRIES);

        $test_transfer_id = $response['transfer_id'];
        $test_coount_id = $response['account_id'];
        $this->assertTrue(!empty($test_transfer_id));
        $this->assertTrue($test_coount_id != $test_transfer_id);
    }

    /**
     * A basic feature test example.
     */
    public function test_planning_recursively_data(): void
    {
        $response = $this->get('/api/planning-recursively/' . self::PLANNING_RECURSIVELY, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::PLANNING);
    }

    /**
     * A basic feature test example.
     */
    public function test_payees_data(): void
    {
        $response = $this->get('/api/payee/', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::PAYEE);
    }

    public function test_filter_account_entry()
    {
        $response = $this->get('/api/entry?filter[account]=10&page=0', $this->getAuthTokenHeader());
        
        $response->assertStatus(200);
        foreach($response['data'] as $data) {
            $assert = $data['account_id'] === 10;
            $this->assertTrue($assert);
        }
    }

    public function test_filter_account_category_entry()
    {
        $response = $this->get('/api/entry?filter[account]=10&filter[category]=5&page=0', $this->getAuthTokenHeader());
        
        $response->assertStatus(200);
        foreach($response['data'] as $data) {
            $assert = $data['category_id'] === 5 && $data['account_id'] === 10;
            $this->assertTrue($assert);
        }
    }

    public function test_filter_type_entry()
    {
        $response = $this->get('/api/entry?filter[type]=incoming&page=0', $this->getAuthTokenHeader());
        
        $response->assertStatus(200);
        foreach($response['data'] as $data) {
            $assert = $data['type'] === 'incoming';
            $this->assertTrue($assert);
        }
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];
    }
}

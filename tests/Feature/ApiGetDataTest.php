<?php

namespace Tests\Feature;

use Tests\TestCase;

require_once 'app/User/Tests/AuthTest.php';

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
        "uuid",
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
            "date",
            "type",
            "installement",
            "installementValue",
            "currency",
            "balance"
        ],
        "currency_id",
        "payment_type",
        "planning",
        "end_date_time"
    ];

    const MODEL = [
        [
            "uuid",
            "amount",
            "note",
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
                "date",
                "type",
                "installement",
                "installementValue",
                "currency",
                "balance"
            ],
            "currency_id",
            "payment_type",
        ]
    ];

    const PAYEE = [
        [
            "date_time",
            "entry",
            "id",
            "name",
            "uuid"
        ]
    ];

    const CURRENCY = [
        "data" => [
            [
                "id",
                "date_time",
                "uuid",
                "name",
                "label",
                "icon",
                "exchange_rate"
            ]
        ]
    ];

    const ACCOUNT = [
        [
            "id",
            "date_time",
            "uuid",
            "name",
            "color",
            "exclude_from_stats",
            "deleted_at",
            "date",
            "type",
            "installement",
            "installementValue",
            "currency",
            "balance",
            "sorting"
        ]
    ];

    const SETTINGS = [
        "settings" =>  [
            "id",
            "created_at",
            "updated_at",
            "setting",
            "data"
        ],
        "user_profile" => [
            "id",
            "name",
            "email",
            "email_verified_at",
            "password",
            "remember_token",
            "created_at",
            "updated_at",
            "deleted_at",
            "uuid"
        ],
        "currency" => [
            "id",
            "date_time",
            "uuid",
            "name",
            "label",
            "icon",
            "exchange_rate"
        ],
        "paymentType" => [
            "id",
            "date_time",
            "uuid",
            "name"
        ]
    ];

    const INCOMING_ID = '64b54cc566d77_test';
    const EXPENSES_ID = '64b54cc5677e0_test';
    const DEBIT_ID = '64b54cc568334_test';
    const TRANSFER_ID = '64b54d02cdcfd_test';
    const PLANNING_RECURSIVELY = '64b54cc56942d_test';

    public function get_all_incoming_data(): void
    {
        $response = $this->get('/api/incoming/');

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
        $response = $this->get('/api/incoming/' . self::INCOMING_ID);

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
        $response = $this->get('/api/expenses/' . self::EXPENSES_ID);

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
        $response = $this->get('/api/debit/' . self::DEBIT_ID);

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
        $response = $this->get('/api/transfer/' . self::TRANSFER_ID);

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
        $response = $this->get('/api/planning-recursively/' . self::PLANNING_RECURSIVELY);

        $response->assertStatus(200);
        $response->assertJsonStructure(self::PLANNING);
    }

    /**
     * A basic feature test example.
     */
    public function test_payees_data(): void
    {
        $response = $this->get('/api/payee/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::PAYEE);
    }

    public function test_filter_account_entry()
    {
        $response = $this->get('/api/entry?filter[account]=10&page=0');

        $response->assertStatus(200);
        foreach ($response['data'] as $data) {
            $assert = $data['account_id'] === 10;
            $this->assertTrue($assert);
        }
    }

    public function test_filter_account_category_entry()
    {
        $response = $this->get('/api/entry?filter[account]=10&filter[category]=5&page=0');

        $response->assertStatus(200);
        foreach ($response['data'] as $data) {
            $assert = $data['category_id'] === 5 && $data['account_id'] === 10;
            $this->assertTrue($assert);
        }
    }

    public function test_filter_type_entry()
    {
        $response = $this->get('/api/entry?filter[type]=incoming&page=0');

        $response->assertStatus(200);
        foreach ($response['data'] as $data) {
            $assert = $data['type'] === 'incoming';
            $this->assertTrue($assert);
        }
    }

    public function test_get_currency()
    {
        $response = $this->get('/api/currencies');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::CURRENCY);
    }

    public function test_get_model()
    {
        $response = $this->get('/api/model');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::MODEL);
    }

    public function test_get_wallets()
    {
        $response = $this->get('/api/accounts/');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ACCOUNT);
    }

    public function test_get_wallet()
    {
        $response = $this->get('/api/accounts/1');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ACCOUNT[0]);
    }

    public function test_get_trashed_wallet()
    {
        $response = $this->get('/api/accounts/?trashed=1');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ACCOUNT);
    }

    public function test_get_user_settings()
    {
        $response = $this->get('/api/user/settings');

        $response->assertStatus(200);
        $response->assertJsonStructure(self::SETTINGS);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];
    }
}

<?php

namespace App\Search\Tests;

use Tests\TestCase;

class SearchTest extends TestCase
{

    const PAYLOAD = [
        "password" => "password",
        "confirmed_password" => "foo@email.it",
        "email" => "foo@email.it",
        "name" => "foo bar"
    ];

    const ENTRY = [
        "data" => [
            [
                "uuid",
                "amount",
                "note",
                "type",
                "waranty",
                "confirmed",
                "planned",
                "category_id",
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
            ]
        ],
        "balance",
        "hasMorePages",
        "currentPage",
        "paginate"
    ];

    /**
     * A basic feature test example.
     */
    public function test_search_from_label_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => ["expenses","incoming"],
            "tags" => [1],
            "text" => null,
            "planned" => null
        ];

        $response = $this->postJson(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $foundLabel = false;
        foreach ($response['data']as $data) {
            foreach ($data['label'] as $label) {
                if ($label['id'] == 1) {
                    $foundLabel = true;
                }
            }
        }

        $this->assertTrue($foundLabel);
    }

    public function test_search_from_category_data(): void
    {
        $payload = [
            "account" => null,
            "category" => [2],
            "type" => [],
            "tags" => [],
            "text" => null,
            "planned" => null
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            if ($data['category_id'] != 2) {
                $found = false;
            }
        }

        $this->assertTrue($found);
    }

    public function test_search_from_incoming_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => ["incoming"],
            "tags" => [],
            "text" => null,
            "planned" => null
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            if ($data['type'] != 'incoming') {
                $found = true;
            }
        }

        $this->assertTrue($found);
    }

    public function test_search_from_expenses_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => ["expenses"],
            "tags" => [],
            "text" => null,
            "planned" => null
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            if ($data['type'] != 'expenses') {
                $found = true;
            }
        }

        $this->assertTrue($found);
    }

    public function test_search_from_account_data(): void
    {
        $payload = [
            "account" => [4],
            "category" => null,
            "type" => ["expenses"],
            "tags" => [],
            "text" => null,
            "planned" => null
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            if ($data['account_id'] != 4) {
                $found = false;
            }
        }

        $this->assertTrue($found);
    }

    public function test_search_from_planning_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => ["expenses"],
            "tags" => [],
            "text" => null,
            "planned" => 1
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            if ($data['planned'] == 0) {
                $found = false;
            }
        }

        $this->assertTrue($found);
    }

    public function test_search_from_text_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => null,
            "tags" => [],
            "text" => 'it is a test simple',
            "planned" => null
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $this->assertCount(1, $response['data']);
    }

    public function test_search_from_dateTime_month_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => null,
            "tags" => [],
            "text" => null,
            "planned" => null,
            "month" => '04'
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            $time = new \DateTime($data['date_time']);
            if ($time->format("m") != '04') {
                $found = false;
            }
        }

        $this->assertTrue($found);

    }

    public function test_search_from_dateTime_year_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => null,
            "tags" => [],
            "text" => null,
            "planned" => null,
            "year" => '2023'
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            $time = new \DateTime($data['date_time']);
            if ($time->format("Y") != '2023') {
                $found = false;
            }
        }

        $this->assertTrue($found);

    }

    public function test_search_from_dateTime_year_month_data(): void
    {
        $payload = [
            "account" => null,
            "category" => null,
            "type" => null,
            "tags" => [],
            "text" => null,
            "planned" => null,
            "year" => '2022',
            "month" => '04'
        ];

        $response = $this->post(
            "/search/filter?page=0",
            $payload,
            $this->getAuthTokenHeader()
        );

        $response->assertStatus(200);
        $response->assertJsonStructure(self::ENTRY);

        $found = true;
        foreach ($response['data']as $data) {
            $time = new \DateTime($data['date_time']);
            if ($time->format("m") != '04' && $time->format("Y") != '2022') {
                $found = false;
            }
        }

        $this->assertTrue($found);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', self::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];
    }
}

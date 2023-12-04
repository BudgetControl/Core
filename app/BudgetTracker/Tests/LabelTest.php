<?php

namespace Tests\Feature;

use Tests\TestCase;

require_once 'app/User/Tests/AuthTest.php';

class LabelTest extends TestCase
{
    const STRUCTURE = [
        ["archive",
        "color",
        "date_time",
        "id",
        "name",
        "uuid",]
    ];

    /**
     * A basic feature test example.
     */
    public function test_label_data(): void
    {
        $response = $this->get('/api/labels/', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::STRUCTURE);
    }

    /**
     * A basic feature test example.
     */
    public function test_get_label_data(): void
    {
        $response = $this->get('/api/labels/1/', $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::STRUCTURE);
    }

    /**
     * A basic feature test example.
     */
    public function test_new_label_data(): void
    {
        $data = [
            "archive" => 0,
            "color" => "#000fff",
            "date_time" => date("Y-m-d H:i:s"),
            "name" => 'test',
        ];

        $response = $this->post('/api/labels/',$data, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $this->assertDatabaseHas("labels",[
            "name" => "test"
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_update_label_data(): void
    {
        $data = [
            "archive" => 0,
            "color" => "#000fff",
            "date_time" => date("Y-m-d H:i:s"),
            "name" => 'test_update',
        ];

        $response = $this->post('/api/labels/',$data, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $this->assertDatabaseHas("labels",[
            "name" => "test_update"
        ]);

    }

    /**
     * A basic feature test example.
     */
    public function test_archive_label_data(): void
    {
        $data = [
            "archive" => 1,
            "color" => "#000fff",
            "date_time" => date("Y-m-d H:i:s"),
            "name" => 'test_update',
        ];

        $response = $this->post('/api/labels/',$data, $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $this->assertDatabaseHas("labels",[
            "name" => "test_update",
            "archive" => 1
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

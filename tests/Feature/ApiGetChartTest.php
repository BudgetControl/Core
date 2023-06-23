<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiGetChartTest extends TestCase
{
    const BAR = [
        "series" => [
            [
                "label",
                "value",
                "color",
            ],
        ]
    ];

    const LINE = [
        "series" => [
            [
                "label",
                "color",
                "points" => [
                    [
                        "label",
                        "x",
                        "y"
                    ],
                ]
            ],
        ]
    ];

    const TABLE = [
        "series" => [
            [
                "value",
                "value_previus",
                "label",
                "bounce_rate"
            ],
        ]
    ];



    /**
     * A basic feature test example.
     */
    public function test_line_incoming_expenses_data(): void
    {
        $y = date('Y',time());
        $m = date('m',time());

        $response = $this->get("/api/chart/line/incoming-expenses?date_time[0][start]=$y%2F$m%2F$m&date_time[0][end]=$y%2F$m%2F28&date_time[1][start]=$y%2F02%2F$m&date_time[1][end]=$y%2F02%2F28&date_time[2][start]=$y%2F03%2F$m&date_time[2][end]=$y%2F03%2F28&date_time[3][start]=$y%2F04%2F$m&date_time[3][end]=$y%2F04%2F28&date_time[4][start]=$y%2F05%2F$m&date_time[4][end]=$y%2F05%2F28&date_time[5][start]=$y%2F06%2F$m&date_time[5][end]=$y%2F06%2F28&date_time[6][start]=$y%2F07%2F$m&date_time[6][end]=$y%2F07%2F28&date_time[7][start]=$y%2F08%2F$m&date_time[7][end]=$y%2F08%2F28&date_time[8][start]=$y%2F09%2F$m&date_time[8][end]=$y%2F09%2F28&date_time[9][start]=$y%2F10%2F$m&date_time[9][end]=$y%2F10%2F28&date_time[10][start]=$y%2F11%2F$m&date_time[10][end]=$y%2F11%2F28&date_time[11][start]=$y%2F12%2F$m&date_time[11][end]=$y%2F12%2F28", 
        $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::LINE);

    }

    public function test_table_expenses_category_data(): void
    {
        $y = date('Y',time());
        $m = date('m',time());

        $response = $this->get("/api/chart/table/expenses/category?date_time[0][start]=$y%2F06%2F$m&date_time[0][end]=$y%2F06%2F20", 
        $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::TABLE);
    }

    public function test_bar_expenses_category_data(): void
    {
        $y = date('Y',time());
        $m = date('m',time());

        $response = $this->get("/api/chart/bar/expenses/category?date_time[0][start]=$y%2F06%2F$m&date_time[0][end]=$y%2F06%2F20", 
        $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::BAR);
    }

    public function test_bar_expenses_label_data(): void
    {
        $y = date('Y',time());
        $m = date('m',time());

        $response = $this->get("/api/chart/bar/expenses/label?date_time[0][start]=$y%2F06%2F$m&date_time[0][end]=$y%2F06%2F20", 
        $this->getAuthTokenHeader());

        $response->assertStatus(200);
        $response->assertJsonStructure(self::BAR);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['access_token' => $token];
    }
}

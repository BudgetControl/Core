<?php

namespace Tests\Feature;

use App\BudgetTracker\Enums\AccountType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\BudgetTracker\Models\Account;

require_once 'app/User/Tests/AuthTest.php';

class AccountTest extends TestCase
{
    const PAYLOAD = [
        "name" => "bank account",
        "type" => "Bank",
        "color" =>  "#00012223",
        "currency" => "EUR",
        "installement" => 0,
        "balance" => 0,
        "exclude_from_stats" => 0
    ];

    const STRUCTURE = [
        "data" => [
            [
                "id",
                "date_time",
                "uuid",
                "name",
                "color",
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
        $request['type'] = 'Credit Card';

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
            'balance' => 1024
        ]);
    }

    public function update_bank_balance_test()
    {
        $dateTime = new \DateTime();

        $request = '{ 
            "amount": 200.00,
            "note" : "test",
            "category_id":12,
            "account_id" : 10,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "' . $dateTime->format('Y-m-d H:i:s') . '", 
            "label": [],
            "waranty": 1,
            "confirmed": 1
        }';
        $request = json_decode($request);

        $this->post('/api/incoming/', $request, $this->getAuthTokenHeader());

        $this->assertDatabaseHas(Account::class, [
            'balance' => 1200
        ]);

        $request['amount'] = 100.00;
        $request['transfer_to'] = 9;
        $this->post('/api/transfer/', $request, $this->getAuthTokenHeader());

        $this->assertDatabaseHas(Account::class, [
            'balance' => 1100,
            'id' => 10
        ]);

        $this->assertDatabaseHas(Account::class, [
            'balance' => -1900,
            'id' => 9
        ]);
    }

    public function update_credit_card_balance_debit_test()
    {
        $dateTime = new \DateTime();

        $request = '{ 
            "amount": -500.00,
            "note" : "test",
            "category_id":12,
            "account_id" : 10,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "' . $dateTime->format('Y-m-d H:i:s') . '", 
            "label": [],
            "waranty": 1,
            "confirmed": 1
            "payee": "pippo"
        }';
        $request = json_decode($request);

        $this->post('/api/payee/', $request, $this->getAuthTokenHeader());

        $this->assertDatabaseHas(Account::class, [
            'balance' => 500,
            'id' => 10
        ]);
    }

    public function update_credit_card_balance_test()
    {
        $dateTime = new \DateTime();

        $request = '{ 
            "amount": -100.00,
            "note" : "test",
            "category_id":12,
            "account_id" : 9,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "' . $dateTime->format('Y-m-d H:i:s') . '", 
            "label": [],
            "waranty": 1,
            "confirmed": 1
        }';
        $request = json_decode($request);

        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());

        $this->assertDatabaseHas(Account::class, [
            'balance' => -1800,
            'id' => 9
        ]);
    }

    public function update_credit_card_balance_when_update_entry_test()
    {
        $dateTime = new \DateTime();

        $request = '{ 
            "uuid": "649be7171e9cc",
            "amount": -100.00,
            "note" : "test",
            "category_id":12,
            "account_id" : 9,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "' . $dateTime->format('Y-m-d H:i:s') . '", 
            "label": [],
            "waranty": 1,
            "confirmed": 1
        }';
        $request = json_decode($request);
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 360,
            'id' => 9
        ]);

        $request['confirmed'] = 0;
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 460,
            'id' => 9
        ]);


        $request['confirmed'] = 1;
        $request['date_time'] = '2023-04-28 10:10:10';
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 360,
            'id' => 9
        ]);

        $request['confirmed'] = 1;
        $request['date_time'] = '2023-09-28 10:10:10';
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 460,
            'id' => 9
        ]);

        $request['confirmed'] = 1;
        $request['date_time'] = $dateTime->format('Y-m-d H:i:s');
        $reuqest['note'] = 'foo bar';
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 460,
            'id' => 9,
            'note' => 'foo bar'
        ]);

        $request = '{ 
            "uuid": "649be7171e9cc",
            "amount": -100.00,
            "note" : "test",
            "category_id":12,
            "account_id" : 9,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "2023-09-28 10:10:10", 
            "label": [],
            "waranty": 1,
            "confirmed": 1
        }';
        $request = json_decode($request);
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $request = json_decode($request);
        $this->assertDatabaseHas(Account::class, [
            'balance' => 460,
            'id' => 9,
            'note' => 'foo bar'
        ]);

        $request['date_time'] = "2023-05-28 10:10:10";
        $request['amount'] = -300.00;
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 160,
            'id' => 9,
            'note' => 'foo bar'
        ]);

        $request['amount'] = -100.00;
        $this->post('/api/expenses/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 360,
            'id' => 9,
            'note' => 'foo bar'
        ]);

        $request['amount'] = 1000.00;
        $this->post('/api/incoming/', $request, $this->getAuthTokenHeader());
        $this->assertDatabaseHas(Account::class, [
            'balance' => 1460,
            'id' => 9,
            'note' => 'foo bar'
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

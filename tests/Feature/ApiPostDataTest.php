<?php

namespace Tests\Feature;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Models\PlannedEntries;
use DateTime;
use App\BudgetTracker\Models\Entry;
use Tests\TestCase;

class ApiPostDataTest extends TestCase
{

    private $headers = '';


    /**
     * A basic feature test example.
     */
    public function test_incoming_data(): void
    {

        $request = $this->makeRequest(100.90, new DateTime());

        $response = $this->postJson('/api/incoming',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(Entry::class,[
            'amount' => 100.90,
            'type' => EntryType::Incoming->value,
            'category_id' => 12,
            'account_id' => 1,
            'planned' => 0,
            'transfer' => 0,
            'confirmed' => 1
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_incoming_data_planned(): void
    {
        $request = $this->makeRequest(100.90, new DateTime('+5day'));

        $response = $this->postJson('/api/incoming',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(Entry::class,[
            'amount' => 100.90,
            'type' => EntryType::Incoming->value,
            'category_id' => 12,
            'account_id' => 1,
            'planned' => 1,
            'transfer' => 0,
            'confirmed' => 1
        ]);
    }

        /**
     * A basic feature test example.
     */
    public function test_incoming_data_recursively(): void
    {
        $request = $this->makeRequest(100.90, new DateTime('+1Month'));
        $request->planning = 'daily';

        $response = $this->postJson('/api/planning-recursively',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(PlannedEntries::class,[
            'amount' => 100.90,
            'type' => EntryType::Incoming->value,
            'category_id' => 12,
            'account_id' => 1,
            'confirmed' => 1,
            'planning' => PlanningType::Day->value
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_expenses_data(): void
    {
        $request = $this->makeRequest(-100.90, new DateTime());

        $response = $this->postJson('/api/expenses',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(Entry::class,[
            'amount' => -100.90,
            'type' => EntryType::Expenses->value,
            'category_id' => 12,
            'account_id' => 1,
            'planned' => 0,
            'transfer' => 0,
            'confirmed' => 1
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_transfer_data(): void
    {
        $request = $this->makeRequest(1024.90, new DateTime());
        $request->transfer_id = 2;

        $response = $this->postJson('/api/transfer',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(Entry::class,[
            'amount' => -1024.90,
            'type' => EntryType::Transfer->value,
            'category_id' => 75,
            'account_id' => 1,
            'transfer_id' => 2,
            'planned' => 0,
            'transfer' => 1,
            'confirmed' => 1
        ]);

        $this->assertDatabaseHas(Entry::class,[
            'amount' => 1024.90,
            'type' => EntryType::Transfer->value,
            'category_id' => 75,
            'account_id' => 2,
            'transfer_id' => 1,
            'planned' => 0,
            'transfer' => 1,
            'confirmed' => 1
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_debit_data(): void
    {
        $request = $this->makeRequest(-200.90, new DateTime());
        $request->payee_id = 'Gino';

        $response = $this->postJson('/api/debit',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(Entry::class,[
            'amount' => -200.90,
            'type' => EntryType::Debit->value,
            'category_id' => 55,
            'account_id' => 1,
            'payee_id' => 1,
            'planned' => 0,
            'transfer' => 0,
            'confirmed' => 1
        ]);

        $this->assertDatabaseHas(Payee::class,[
            'name' => 'Gino',
        ]);
    }

        /**
     * A basic feature test example.
     */
    public function test_new_debit_data(): void
    {
        $request = $this->makeRequest(-200.90, new DateTime());
        $request->payee_id = 'Mimmo';
        $request->category_id = 55;

        $response = $this->postJson('/api/debit',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(Entry::class,[
            'amount' => -200.90,
            'type' => EntryType::Debit->value,
            'category_id' => 55,
            'account_id' => 1,
            'payee_id' => 11,
            'planned' => 0,
            'transfer' => 0,
            'confirmed' => 1
        ]);

        $this->assertDatabaseHas(Payee::class,[
            'name' => 'Mimmo',
        ]);
    }

    /**
     * build model request
     * @param float $amount
     * @param DateTime $dateTime
     * 
     * @return object
     */
    private function makeRequest(float $amount, DateTime $dateTime): object
    {
        $request = '{ 
            "amount": '.$amount.',
            "note" : "test",
            "category_id":12,
            "account_id" : 1,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "'.$dateTime->format('Y-m-d h:i:s').'", 
            "label": [],
            "installment": 0
        }';

        return json_decode($request);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['access_token' => $token];  
    }
}

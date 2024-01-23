<?php

namespace Tests\Feature;

use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Enums\PlanningType;
use App\BudgetTracker\Models\Payee;
use App\BudgetTracker\Models\PlannedEntries;
use DateTime;
use App\BudgetTracker\Models\Entry;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\BudgetTracker\Models\Account;
require_once 'app/User/Tests/AuthTest.php';

class ApiPostDataTest extends TestCase
{

    const ACCOUNT_ID = '64b59d645b752_test';

    /**
     * A basic feature test example.
     */
    public function test_update_transfer_data(): void
    {
        $payload = $this->makeTransferRequest(500,new DateTime());

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
            "account_id" => 4
        ]);

        $this->assertDatabaseHas("entries",[
            "amount" => 500,
            "uuid" => "64b54d02cdcft_test",
            "type" => "transfer",
            "planned" => 0,
            "transfer_id" => 4,
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
    private function makeTransferRequest(float $amount, DateTime $dateTime): array
    {
        $request = '{ 
            "amount": '.$amount.',
            "note" : "test",
            "category_id":12,
            "account_id" : 4,
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

    /**
     * A basic feature test example.
     */
    public function test_update_expenses_data(): void
    {
        $payload = $this->makeRequest(-500,new DateTime());

        $response = $this->putJson(
            "api/expenses/64b54cc566d77_test",
            (array) $payload,
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
            (array) $payload,
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
            (array) $payload,
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
        $payload->confirmed = false;

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            (array) $payload,
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
        $payload->note = "test note";

        $response = $this->putJson(
            "api/incoming/64b54cc566d77_test",
            (array) $payload,
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
            'account_id' => 4,
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
            'account_id' => 4,
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
        $request->end_date_time = "2025-08-10 00:00:00";

        $response = $this->postJson('/api/planning-recursively',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertDatabaseHas(PlannedEntries::class,[
            'amount' => 100.90,
            'type' => EntryType::Incoming->value,
            'category_id' => 12,
            'account_id' => 4,
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
            'account_id' => 4,
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
            'account_id' => 4,
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
            'transfer_id' => 4,
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
            'account_id' => 4,
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
            'account_id' => 4,
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
    * A basic feature test example.
    */
   public function test_investments_data(): void
   {

       $request = $this->makeRequest(-1000, new DateTime());
       $request->category_id = 60;

       $response = $this->postJson('/api/investments',(array) $request,$this->getAuthTokenHeader());
       $response->assertStatus(200);

       $this->assertDatabaseHas(Entry::class,[
           'amount' => -1000,
           'type' => EntryType::Investments->value,
           'category_id' => 60,
           'account_id' => 4,
           'planned' => 0,
           'transfer' => 0,
           'confirmed' => 1
       ]);
   }

    /**
    * A basic feature test example.
    */
    public function test_model_data(): void
    {
 
        $request = $this->makeRequest(1000, new DateTime());
        $request->category_id = 60;
        $request->name = "test";
        $request->type = "incoming";
 
        $response = $this->postJson('/api/model',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);
 
        $this->assertDatabaseHas('models',[
            'amount' => 1000,
            'type' => EntryType::Incoming->value,
            'category_id' => 60,
            'account_id' => 4,
            'name' => 'test'
        ]);
    }

    /**
    * A basic feature test example.
    */
    public function test_update_model_data(): void
    {
 
        $request = $this->makeRequest(500, new DateTime());
        $request->category_id = 60;
        $request->type = "incoming";
        $request->name = "test";
        
        $response = $this->putJson('/api/model/65719bc11c897',(array) $request,$this->getAuthTokenHeader());
        $response->assertStatus(200);
 
        $this->assertDatabaseHas('models',[
            'amount' => 500,
            'type' => EntryType::Incoming->value,
            'category_id' => 60,
            'account_id' => 4,
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
            "account_id" : 4,
            "currency_id": 1,
            "payment_type" : 1,
            "date_time": "'.$dateTime->format('Y-m-d H:i:s').'",
            "label": [],
            "waranty": 1,
            "confirmed": 1
        }';

        return json_decode($request);
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];  
    }

}

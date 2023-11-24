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

class DeleteDataTest extends TestCase
{

    const ACCOUNT_ID = '64b59d645b752_test';

    /**
     *  DELETE ENTRY
     */
    public function test_delete_incoming() {
        $response = $this->deleteJson('/api/incoming/'.ApiGetDataTest::INCOMING_ID,[],$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertTrue($this->isDeleted(ApiGetDataTest::INCOMING_ID));
        $this->assertTrue($this->checkBalance(self::ACCOUNT_ID,4000));
    }

    /**
     *  DELETE ENTRY
     */
    public function test_delete_expenses() {
        $response = $this->deleteJson('/api/expenses/'.ApiGetDataTest::EXPENSES_ID,[],$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertTrue($this->isDeleted(ApiGetDataTest::EXPENSES_ID));
        $this->assertTrue($this->checkBalance(self::ACCOUNT_ID,6000));
    }

    /**
     *  DELETE ENTRY
     */
    public function test_delete_debit() {
        $response = $this->deleteJson('/api/debit/'.ApiGetDataTest::DEBIT_ID,[],$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertTrue($this->isDeleted(ApiGetDataTest::DEBIT_ID));
        $this->assertTrue($this->checkBalance(self::ACCOUNT_ID,6000));
    }

    /**
     *  DELETE ENTRY
     */
    public function test_delete_planned_entry() {
        $response = $this->deleteJson('/api/planning-recursively/'.ApiGetDataTest::PLANNING_RECURSIVELY,[],$this->getAuthTokenHeader());
        $response->assertStatus(200);

        $this->assertTrue($this->isDeleted(ApiGetDataTest::PLANNING_RECURSIVELY,'planned_entries'));
    }

    private function getAuthTokenHeader()
    {
        //first we nee to get a new token
        $response = $this->post('/auth/authenticate', AuthTest::PAYLOAD);
        $token = $response['token']['plainTextToken'];
        return ['X-ACCESS-TOKEN' => $token];  
    }

    private function isDeleted(string $id,string $table = 'entries'):bool
    {
        $row = DB::table($table)->where('uuid',$id)->withTrashed()->get()->count();
        return $row !== 0;
    }

    private function checkBalance(string $accountId, float $mustHave): bool
    {
        $account = Account::where('uuid',$accountId)->firstOrFail('balance');
        $balance = $account->balance;

        return $balance === $mustHave;
    }
}

<?php

namespace Database\Seeders;

use App\BudgetTracker\Enums\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Account;

class AccountSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lang = "it"; //env("LANG", "it");
        $path = __DIR__ . '/../sql/account.json';
        $data = (array) json_decode(file_get_contents($path));

        foreach ($data[$lang] as $key => $value) {
            $db = new Account();
            $db->uuid = (empty($value->uuid)) ? \Ramsey\Uuid\Uuid::uuid4()->toString() : $value->uuid;
            $db->name = $value->name;
            $db->type = $value->type;
            $db->user_id = 1;
            $db->save();
        }

        Account::factory(1)->create([
            'installement' => 1,
            'type' => 'Bank',
            'balance' => 5000.00,
            'uuid' => '64b59d645b752_test'
        ]);

        Account::factory(8)->create([
        ]);

        Account::factory(1)->create([
            'installement' => 1,
            'installementValue' => 200,
            'type' => 'Credit Card',
            'date' => '2023-06-12',
            'balance' => -2000.00,
        ]);

        Account::factory(1)->create([
            'installement' => 1,
            'type' => 'Bank',
            'balance' => 1000.00,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Debit;

class DebitSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Debit::factory(1)->create([
            'user_id' => 1
        ]);

        Debit::factory(1)->create([
            'user_id' => 1,
            'uuid' => '64b54cc568334_test',
            'account_id' => 1,
            'amount' => -1000
        ]);
    }
}

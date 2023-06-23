<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Transfer;

class TransferSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transfer::factory(1)->create([
            'user_id' => 1
        ]);
        Transfer::factory(1)->create([
            'transfer_id' => 1,
            'account_id' => 1,
            'amount' => 200,
            'user_id' => 1
        ]);
    }
}

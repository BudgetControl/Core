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
    }
}

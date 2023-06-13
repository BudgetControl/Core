<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Incoming;

class IncomingSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incoming::factory(10)->create([
            'user_id' => 1
        ]);
    }
}

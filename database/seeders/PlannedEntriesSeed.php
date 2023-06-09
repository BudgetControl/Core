<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\PlannedEntries;

class PlannedEntriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlannedEntries::factory(10)->create([
            'user_id' => 1
        ]);
    }
}

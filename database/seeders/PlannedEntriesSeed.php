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
        PlannedEntries::factory(10)->create();

        $date = new \DateTime();
        $date->modify("+ 1month");

        PlannedEntries::factory(1)->create([
            'end_date_time' => $date->format('Y-m-d H:i:s')
        ]);

        PlannedEntries::factory(1)->create([
            'end_date_time' => $date->format('Y-m-d H:i:s'),
            'uuid' => '64b54cc56942d_test'
        ]);
    }
}

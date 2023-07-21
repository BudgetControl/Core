<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Incoming;
use \App\BudgetTracker\Models\Labels;


class IncomingSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Incoming::factory(200)->create([
            'user_id' => 1
        ]);

        $labels = Labels::factory(10)->create([
            'user_id' => 1
        ]);

        Incoming::factory(1)->create([
            'user_id' => 1,
            'uuid' => '64b54cc566d77_test',
            'account_id' => 1,
            'amount' => 1000
        ]);

        Incoming::all()->each(function ($incoming) use ($labels) {
            $incoming->label()->saveMany($labels);
        });

        
    }
}

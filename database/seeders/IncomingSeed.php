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

        $incoming = Incoming::factory(1000)->create([
            'user_id' => 1
        ]);

        $labels = Labels::factory(10)->create([
            'user_id' => 1
        ]);

        Incoming::all()->each(function ($incoming) use ($labels) {
            $incoming->label()->saveMany($labels);
        });

        
    }
}

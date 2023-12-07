<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\Labels;
use App\BudgetTracker\Models\Models;

class ModelsSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Models::factory(5)->create([
            'user_id' => 1
        ]);

        $labels = Labels::factory(1)->create([
            'user_id' => 1
        ]);

        Models::all()->each(function ($models) use ($labels) {
            $models->label()->saveMany($labels);
        });
        
    }
}

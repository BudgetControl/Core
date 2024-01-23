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

        Models::factory(4)->create();

        Models::factory(4)->create([
            'uuid' => '65719bc11c897'
        ]);

        $labels = Labels::factory(1)->create();

        Models::all()->each(function ($models) use ($labels) {
            $models->label()->saveMany($labels);
        });
        
    }
}

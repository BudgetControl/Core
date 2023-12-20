<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Incoming;
use \App\BudgetTracker\Models\Labels;
use Faker\Provider\DateTime;

class IncomingSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Incoming::factory(100)->create([
            'user_id' => 1
        ]);

        Incoming::factory(1)->create([
            'user_id' => 1,
            'date_time' => "2023-04-12 20:10:00"
        ]);

        Incoming::factory(1)->create([
            'user_id' => 1,
            'date_time' => "2022-04-12 20:10:00"
        ]);

        Incoming::factory(5)->create(
            [
                'user_id' => 1,
                'planned' => 1,
                'date_time' => DateTime::dateTimeBetween('now','+2 months')
            ]
        );

        $labels = Labels::factory(1)->create([
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

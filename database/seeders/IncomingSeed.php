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

        Incoming::factory(100)->create();

        Incoming::factory(1)->create([
            'date_time' => "2023-04-12 20:10:00"
        ]);

        Incoming::factory(1)->create([
            'date_time' => "2022-04-12 20:10:00"
        ]);

        Incoming::factory(5)->create(
            [
                'planned' => 1,
                'date_time' => DateTime::dateTimeBetween('now','+2 months')
            ]
        );

        $labels = Labels::factory(1)->create();

        Incoming::factory(1)->create([
            'uuid' => '64b54cc566d77_test',
            'account_id' => 4,
            'amount' => 1000,
            'planned' => 0,
            'date_time' => '2023-12-30'
        ]);

        Incoming::factory(1)->create([
            'uuid' => '64b54cc566d77_balancetest',
            'account_id' => 5,
            'amount' => 1000,
            'planned' => 0,
            'date_time' => '2023-12-30',
            'confirmed' => 1
        ]);

        Incoming::all()->each(function ($incoming) use ($labels) {
            $incoming->label()->saveMany($labels);
        });

        
    }
}

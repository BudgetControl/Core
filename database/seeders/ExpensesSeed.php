<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Expenses;
use \App\BudgetTracker\Models\Labels;
use Faker\Provider\DateTime;

class ExpensesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expenses::factory(200)->create();

        Expenses::factory(5)->create([
            'date_time' => "2023-04-12 20:10:00"
        ]);

        Expenses::factory(1)->create([
            'date_time' => date('Y-m-d H:i:s'),
            'uuid' => '64b54cc5677e0_job',
            'planned' => 1
        ]);

        Expenses::factory(20)->create([
            'planned' => 1,
            'date_time' => DateTime::dateTimeBetween('now','+2 months')
        ]);

        Expenses::factory(1)->create([
            'note' => 'it is a test simple'
        ]);

        $labels = Labels::factory(1)->create();

        Expenses::factory(1)->create([
            'uuid' => '64b54cc5677e0_test',
            'account_id' => 4,
            'amount' => -1000
        ]);

        Expenses::all()->each(function ($expenses) use ($labels) {
            $expenses->label()->saveMany($labels);
        });
    }
}

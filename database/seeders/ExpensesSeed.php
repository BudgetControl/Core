<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\BudgetTracker\Models\Expenses;
use \App\BudgetTracker\Models\Labels;

class ExpensesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expenses::factory(200)->create([
            'user_id' => 1
        ]);

        $labels = Labels::factory(10)->create([
            'user_id' => 1
        ]);

        Expenses::factory(1)->create([
            'user_id' => 1,
            'uuid' => '64b54cc5677e0_test',
            'account_id' => 1,
            'amount' => -1000
        ]);

        Expenses::all()->each(function ($expenses) use ($labels) {
            $expenses->label()->saveMany($labels);
        });
    }
}

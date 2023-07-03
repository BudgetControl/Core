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
        $expenses = Expenses::factory(1000)->create([
            'user_id' => 1
        ]);

        $labels = Labels::factory(10)->create([
            'user_id' => 1
        ]);

        Expenses::all()->each(function ($expenses) use ($labels) {
            $expenses->label()->saveMany($labels);
        });
    }
}

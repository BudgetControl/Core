<?php

namespace Database\Seeders;

use App\Budget\Domain\Model\Budget;
use Illuminate\Database\Seeder;

class BudgetSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Budget::factory(5)->create();
    }
}

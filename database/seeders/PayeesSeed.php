<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\Payee;

class PayeesSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payee::factory(1)->create(['name' => 'Gino']);
        Payee::factory(9)->create();
    }
}

<?php

namespace App\BudgetTracker\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BudgetTracker\Enums\EntryType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class ExpensesFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = "\App\\BudgetTracker\\Models\\Expenses";

    protected static $namespace = 'App\\BudgetTracker\\Factories';


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(-1,-50);
        $day = fake()->numberBetween(1,28);
        $month = fake()->numberBetween(1, date("m",time()));
        $year = date("Y",time());

        $date = "$year/$month/$day 12:20:32";

        $planned = 0;
        if(strtotime($date) > time()) {
            $planned = 1;
        }

        return [
            'uuid' => uniqid(),
            'amount' => $amount,
            'note' => fake()->text(80),
            'type' => EntryType::Expenses->value,
            'transfer' => 0,
            'category_id' => fake()->numberBetween(1,75),
            'account_id' => 1,
            'currency_id' => 1,
            'date_time' => strtotime($date),
            'payment_type' => 1,
            'confirmed' => 1,
            'planned' => $planned

        ];
    }
}

<?php

namespace App\BudgetTracker\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Debit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class PayeeFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = "\App\\BudgetTracker\\Models\\Payee";

    protected static $namespace = 'App\\BudgetTracker\\Factories';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(-1,-50);

        return [
            'uuid' => uniqid(),
            'date_time' => date('Y-m-d H:i:s',time()),
            'name' => fake()->text(5),
        ];
    }
}

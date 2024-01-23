<?php

namespace App\BudgetTracker\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BudgetTracker\Enums\EntryType;
use App\BudgetTracker\Models\Debit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class DebitFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = "\App\\BudgetTracker\\Models\\Debit";

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
            'amount' => $amount,
            'note' => fake()->text(80),
            'type' => EntryType::Debit->value,
            'transfer' => 0,
            'category_id' => fake()->numberBetween(1,75),
            'account_id' => 4,
            'currency_id' => 1,
            'date_time' => date('Y-m-d H:i:s',time()),
            'payment_type' => 1,
            'confirmed' => 1,
            'payee_id' => 1,

        ];
    }
}

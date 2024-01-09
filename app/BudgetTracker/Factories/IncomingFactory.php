<?php

namespace App\BudgetTracker\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BudgetTracker\Enums\EntryType;
use Faker\Provider\DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\BudgetTracker\Models\Incoming>
 */
class IncomingFactory extends Factory
{

    
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = "\App\\BudgetTracker\\Models\\Incoming";

    protected static $namespace = 'App\\BudgetTracker\\Factories';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(1,50);

        $date = DateTime::dateTimeBetween('-1 years','+1 years');

        return [
            'uuid' => uniqid(),
            'amount' => $amount,
            'note' => fake()->text(80),
            'type' => EntryType::Incoming->value,
            'transfer' => 0,
            'category_id' => fake()->numberBetween(1,75),
            'account_id' => 1,
            'currency_id' => 1,
            'date_time' => $date->format('Y-m-d H:i:s'),
            'payment_type' => 1,
            'confirmed' => 1,
            'planned' => 0,
            'user_id' => 1
        ];
    }
}

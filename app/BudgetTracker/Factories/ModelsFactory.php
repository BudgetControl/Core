<?php

namespace App\BudgetTracker\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BudgetTracker\Enums\EntryType;
use Faker\Provider\DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\BudgetTracker\Models\Incoming>
 */
class ModelsFactory extends Factory
{

    
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = "\App\\BudgetTracker\\Models\\Models";

    protected static $namespace = 'App\\BudgetTracker\\Factories';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = fake()->numberBetween(1,50);

        return [
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'amount' => $amount,
            'note' => fake()->text(80),
            'type' => EntryType::Incoming->value,
            'category_id' => fake()->numberBetween(1,75),
            'account_id' => 4,
            'currency_id' => 1,
            'payment_type' => 1,
            'name' => fake()->text(10),
            'workspace_id' => 1
        ];
    }
}

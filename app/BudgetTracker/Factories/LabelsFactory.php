<?php

namespace App\BudgetTracker\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\BudgetTracker\Models\Incoming>
 */
class LabelsFactory extends Factory
{

    
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = "\App\\BudgetTracker\\Models\\Labels";

    protected static $namespace = 'App\\BudgetTracker\\Factories';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'uuid' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => fake()->text(5),
            'color' => random_color(),
            'archive' => 0,
            'user_id' => 1
        ];
    }
}

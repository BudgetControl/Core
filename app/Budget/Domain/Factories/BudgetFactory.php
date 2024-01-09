<?php

namespace App\Budget\Domain\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\BudgetTracker\Enums\EntryType;
use App\Budget\Domain\Model\Budget;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class BudgetFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = "\App\\Budget\\Domain\\Model\\Budget";

    protected static $namespace = 'App\\Budget\\Domain\\Factories';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => uniqid(),
            'budget' => 1000,
            'configuration' => '{"type": ["incoming"], "label": [], "account": [3, 4], "balance": 1000, "category": [], "period": "yearly", "name" => "test"}',
            'user_id' => 1,
        ];
    }
}

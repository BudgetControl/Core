<?php

namespace App\BudgetTracker\Factories;

use Faker\Provider\DateTime;
use App\BudgetTracker\Models\Account;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $usrIdDemo =config('app.config.demo_user_id');
        return [
            'uuid' => uniqid(),
            'amount' => $amount,
            'note' => fake()->text(80),
            'type' => EntryType::Incoming->value,
            'category_id' => fake()->numberBetween(1,75),
            'account_id' => Account::where('user_id', $usrIdDemo)->get('id')[0]->id,
            'currency_id' => 1,
            'payment_type' => 1,
            'name' => fake()->text(10),
            'user_id' => config('app.config.demo_user_id')
        ];
    }
}

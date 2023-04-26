<?php

namespace App\BudgetTracker\Providers;

use Faker\Generator as FakerGenerator;
use Illuminate\Database\Eloquent\Factories\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EloquentFactory::class, function ($app){
            $faker = $app->make(FakerGenerator::class);
            $factories_path = '/app/BudgetTracker/Factories';
            return EloquentFactory::construct($faker, $factories_path);
        });
    }
}
<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerFactory();
    }

    public function registerFactory()
    {
        $this->app->bind(Factory::class, function () {
            return Factory::construct(env('FACTORIES_PATH', '/app/BudgetTracker/Factories'));
        });
    }
}

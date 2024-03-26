<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppConfigurationsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $seed = [
            \Database\Seeders\CategorySeeders::class,
                \Database\Seeders\CurrencySeeders::class,
                \Database\Seeders\PaymentTypeSeeders::class,
        ];
        
        $this->call($seed);

    }
}

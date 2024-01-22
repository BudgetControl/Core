<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (env("APP_ENV") == "testing") {
            $this->call(
                [
                    \Database\Seeders\UserSeed::class,
                ]
            );
        }
    }
}

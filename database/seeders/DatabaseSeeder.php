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
        $this->call(
            [
                \Database\Seeders\UserSeed::class,
                \Database\Seeders\IncomingSeed::class,
                \Database\Seeders\ExpensesSeed::class,
                \Database\Seeders\DebitSeed::class,
                \Database\Seeders\TransferSeed::class,
                \Database\Seeders\CategorySeeders::class,
                \Database\Seeders\CurrencySeeders::class,
                \Database\Seeders\PaymentTypeSeeders::class,
                \Database\Seeders\LabelSeeders::class,
                \Database\Seeders\AccountSeed::class,
                \Database\Seeders\PlannedEntriesSeed::class,
                \Database\Seeders\PayeesSeed::class,
                \Database\Seeders\ModelsSeed::class,
                \Database\Seeders\BudgetSeed::class,
                \Database\Seeders\UserSettingsSeed::class,
            ]
        );
    }
}

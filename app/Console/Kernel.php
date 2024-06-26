<?php

namespace App\Console;

use App\Budget\Job\ScheduleBudgetControl;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\BudgetTracker\Jobs\ActivatePlannedEntries;
use App\BudgetTracker\Jobs\InsertPlannedEntry;
use App\Exchange\Job\ExchangeRateJob;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Exchange\Job;

use App\BudgetTracker\Models\Currency;
use App\Exchange\Services\ExchangeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Exception;
use Illuminate\Support\Facades\Log;
use stdClass;

class ExchangeRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        Log::info("Start ExchangeRate JOB");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currencies = Currency::all();

        foreach($currencies as $currency) {
            $currency->exchange_rate = ExchangeService::init()->fetchSpecificRates($currency->label)->getRate($currency->label.'USD');
            $currency->save();
        }
    }
}

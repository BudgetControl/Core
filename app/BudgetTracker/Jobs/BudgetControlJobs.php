<?php

namespace App\BudgetTracker\Jobs;

use App\User\Models\User;
use App\User\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\QueryException;

abstract class BudgetControlJobs
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    abstract function job(): void;

    public function handle()
    {
        $this->job();
    }
}

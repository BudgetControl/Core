<?php

namespace App\BudgetTracker\Jobs;

use App\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\BudgetTracker\Models\Entry;
use Illuminate\Support\Facades\Log;
use App\BudgetTracker\Enums\EntryType;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\BudgetTracker\Services\EntryService;
use Doctrine\DBAL\Query\QueryException;
use Throwable;

abstract class BudgetControlJobs
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    abstract function job(): void;

    public function handle()
    {
        $databases = $this->getUserDatabase();
        foreach($databases as $database) {
            $this->switchDatabase($database);
            $this->job();
        }

    }

    protected function switchDatabase(array $dbName)
    {
        $database_name = $dbName['database_name'];
        try {
            Config::set(['database.connections.mysql.database' => $database_name]);
            DB::purge('mysql');
            DB::reconnect('mysql');
        } catch(QueryException $e) {
            Log::error("No database found ".$database_name);
            Log::debug($e->getMessage());
        }
        

    }

    protected function getUserDatabase(): array
    {
        $usersDatabase = User::all('database_name');
        return $usersDatabase->toArray();
    }
}

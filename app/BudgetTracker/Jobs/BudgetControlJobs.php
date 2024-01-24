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
        $databases = $this->getUserDatabase();
        foreach($databases as $user) {
            UserService::setUserCache($user);
            $this->switchDatabase($user->database_name);
            $this->job();
        }
        $this->reconnect();

    }

    protected function switchDatabase(array $dbName)
    {
        $database_name = $dbName;
        try {
            Config::set(['database.connections.mysql.database' => $database_name]);
            DB::purge('mysql');
            DB::reconnect('mysql');
        } catch(QueryException $e) {
            Log::error("No database found ".$database_name);
            Log::debug($e->getMessage());
        }
        

    }

    protected function getUserDatabase(): \Illuminate\Database\Eloquent\Collection
    {
        $usersDatabase = User::all();
        return $usersDatabase;
    }

    private function reconnect()
    {
        Config::set(['database.connections.mysql.database' => env("DB_DATABASE","budgetV2")]);
        DB::purge('mysql');
        DB::reconnect('mysql');
    }
}

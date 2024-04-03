<?php

namespace App\Stats\Domain\Repository;

/**
 * 
 * 
 * 
 */

use App\User\Services\UserService;
use Illuminate\Support\Facades\DB;

class StatsRepository
{
    private int $userId;

    public function __construct()
    {
        $this->userId = UserService::getCacheUserID();
    }

    public function statsMonthByLabel(?int $month = null, ?int $year = null)
    {
        $userId = $this->userId;
        $month = is_null($month) ? date('m', time()) : $month;
        $year = is_null($year) ? date('Y', time()) : $year;

        $qb = DB::select("CALL CalculateStatsWalletsLabel ($userId, $month, $year);");
        return $qb;
    }

    public function statsMonthByCategory(?int $month = null, ?int $year = null)
    {
        $userId = $this->userId;
        $month = is_null($month) ? date('m', time()) : $month;
        $year = is_null($year) ? date('Y', time()) : $year;

        $qb = DB::select("CALL CalculateStatsWalletsCategory ($userId, $month, $year);");
        return $qb;
    }

    public function statsMonthIncoming(?int $month = null, ?int $year = null)
    {
        $qb = DB::table("stats_wallets_month")->select('incoming as amount')->where('user_id', $this->userId);

        if(!is_null($month)) {
            $qb->where('month', $month);
        }

        if(!is_null($year)) {
            $qb->where('year', $year);
        }

        return $qb->get();
    }
    
    public function statsMonthExpenses(?int $month = null, ?int $year = null)
    {
        $qb = DB::table("stats_wallets_month")->select('expenses as amount')->where('user_id', $this->userId);

        if(!is_null($month)) {
            $qb->where('month', $month);
        }

        if(!is_null($year)) {
            $qb->where('year', $year);
        }

        return $qb->get();
    }

}

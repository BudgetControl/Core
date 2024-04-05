<?php

namespace App\Stats\Domain\Repository;

/**
 * 
 * 
 * 
 */

use App\User\Services\UserService;
use Carbon\Carbon;
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
        $userId = UserService::getCacheUserID();
        $startDate = Carbon::rawParse("$year-$month-01")->startOfMonth()->toDateString();
        $endDate = Carbon::rawParse("$year-$month-01")->endOfMonth()->toDateString();

        $query = "
            SELECT COALESCE(SUM(e.amount), 0) AS total
            FROM entries AS e
            JOIN accounts AS a ON e.account_id = a.id
            WHERE e.type in ('expenses', 'debit')
            AND e.amount < 0
            AND a.installement = 0
            AND e.exclude_from_stats = 0
            AND a.exclude_from_stats = 0
            AND a.deleted_at is null
            AND e.deleted_at is null
            AND e.confirmed = 1
            AND e.planned = 0
            AND e.date_time >= '$startDate'
            AND e.date_time < '$endDate'
            AND a.user_id = $userId;
        ";

        $result = DB::select($query);

        return [
            'total' => $result[0]->total
        ];
    }

}

<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $query = "
        CREATE VIEW stats_expenses_months AS
        SELECT
        e.user_id,
        MONTH(e.date_time) AS month,
        YEAR(e.date_time) AS year,
        a.name AS wallet,
        COALESCE(SUM(e.amount), 0) AS amounts
        FROM
            entries AS e
        LEFT JOIN
            accounts AS a ON a.id = e.account_id
        WHERE
            e.deleted_at IS NULL
            AND e.type in ('expenses', 'debit')
            AND e.amount <= 0
            AND a.deleted_at IS null
            AND e.confirmed = 1
            AND e.planned = 0
            AND e.exclude_from_stats = 0
        GROUP BY
        e.user_id, MONTH(e.date_time), YEAR(e.date_time), a.name
        
		order by year, month;
        ";
        DB:: statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB:: statement('DROP VIEW stats_expenses_months;');
    }
};

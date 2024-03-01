<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   
        $query = "
        CREATE VIEW stats_wallets_year AS
        SELECT
            e.workspace_id,
            YEAR(e.date_time) AS year,
            a.name AS wallet,
            COALESCE(SUM(CASE WHEN e.type IN ('incoming', 'debit') AND e.amount > 0 THEN e.amount ELSE 0 END), 0) AS incoming,
            COALESCE(SUM(CASE WHEN e.type IN ('expenses', 'debit') AND e.amount < 0 THEN e.amount ELSE 0 END), 0) AS expenses
        FROM
            entries AS e
        LEFT JOIN
            accounts AS a ON a.id = e.account_id
        WHERE
            e.deleted_at IS NULL
            AND a.deleted_at IS NULL
            AND e.confirmed = 1
            AND e.planned = 0
            AND e.exclude_from_stats = 0
        GROUP BY
            e.workspace_id, YEAR(e.date_time), a.name
        ORDER BY
            year;
        ";
        DB:: statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB:: statement('DROP VIEW stats_wallets_year;');
    }
};

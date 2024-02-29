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
        CREATE VIEW stats_wallets_category AS
        SELECT
        e.user_id,
        MONTH(e.date_time) AS month,
        YEAR(e.date_time) AS year,
        sc.name AS category,
        COALESCE(SUM(e.amount), 0) AS amounts
        FROM
            entries AS e
        LEFT JOIN
            sub_categories AS sc ON sc.id = e.category_id
        WHERE
            e.deleted_at IS NULL
            AND e.confirmed = 1
            AND e.planned = 0
            AND e.exclude_from_stats = 0
        GROUP BY
        e.user_id, MONTH(e.date_time), YEAR(e.date_time), sc.name
        
		order by year, month;
        ";
        DB:: statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB:: statement('DROP VIEW stats_wallets_category;');
    }   
};

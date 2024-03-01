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
        CREATE PROCEDURE CalculateStatsWalletsCategory(
            IN userId INT,
            IN inMonth INT,
            IN inYear INT
        )
        BEGIN
            SELECT
                e.user_id,
                MONTH(e.date_time) AS month,
                YEAR(e.date_time) AS year,
                sc.name AS category,
                sc.id AS category_id,
                COALESCE(SUM(CASE WHEN e.type IN ('incoming', 'debit') AND e.amount > 0 THEN e.amount ELSE 0 END), 0) AS incoming,
                COALESCE(SUM(CASE WHEN e.type IN ('expenses', 'debit') AND e.amount < 0 THEN e.amount ELSE 0 END), 0) AS expenses
            FROM
                entries AS e
            LEFT JOIN
                sub_categories AS sc ON sc.id = e.category_id
            WHERE
                e.deleted_at IS NULL
                AND e.confirmed = 1
                AND e.planned = 0
                AND e.exclude_from_stats = 0
                AND e.user_id = userId
                AND MONTH(e.date_time) = inMonth
                AND YEAR(e.date_time) = inYear
            GROUP BY
                e.user_id, MONTH(e.date_time), YEAR(e.date_time), sc.name, sc.id
            ORDER BY
                year, month;
        END;
        ";
        DB:: statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB:: statement('DROP PROCEDURE CalculateStatsWalletsCategory;');
    }
};

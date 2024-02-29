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
        CREATE VIEW stats_incoming_months AS
        SELECT
            user_id,
            COALESCE(SUM(amount), 0) AS amounts
        FROM
            entries
        WHERE
            type IN ('incoming', 'debit')
            AND amount > 0
            AND MONTH(date_time) = MONTH(CURRENT_DATE())
            AND YEAR(date_time) = YEAR(CURRENT_DATE())
            AND planned = 0
            AND confirmed = 1
            AND exclude_from_stats = 0
        GROUP BY
    user_id;
        ";
        DB:: statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB:: statement('DROP VIEW stats_incoming_months;');
    }
};

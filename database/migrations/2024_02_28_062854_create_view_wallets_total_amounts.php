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
        CREATE VIEW stats_wallets_amounts AS
            SELECT
                a.name AS wallet,
                SUM(e.amount) AS amount
            FROM
                entries AS e
            LEFT JOIN
                accounts AS a ON a.id = e.account_id
            WHERE
                e.deleted_at IS NULL
                AND a.deleted_at IS NULL
                AND e.confirmed = 1
                AND e.planned = 0
                AND a.exclude_from_stats = 0
            GROUP BY
                a.name;
        ";
        DB:: statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB:: statement('DROP VIEW stats_wallets_amounts;');
    }
};

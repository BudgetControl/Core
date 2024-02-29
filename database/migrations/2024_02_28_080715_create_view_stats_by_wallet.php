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
        CREATE VIEW stats_wallets_tag AS
        SELECT
        e.user_id,
        MONTH(e.date_time) AS month,
        YEAR(e.date_time) AS year,
        l.name AS tag,
        COALESCE(SUM(e.amount), 0) AS total_amount
        FROM
            entries AS e
        RIGHT JOIN
            entry_labels AS el ON el.entry_id = e.id
		RIGHT JOIN
			labels AS l on l.id = el.labels_id
        WHERE
            e.deleted_at IS NULL
            AND e.confirmed = 1
            AND e.planned = 0
            AND l.deleted_at IS NULL
            AND e.exclude_from_stats = 0
        GROUP BY
        e.user_id, MONTH(e.date_time), YEAR(e.date_time), l.name
        
		order by year, month;
        ";
        DB:: statement($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB:: statement('DROP VIEW stats_wallets_tag;');
    }
};

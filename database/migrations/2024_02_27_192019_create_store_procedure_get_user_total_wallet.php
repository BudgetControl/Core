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
        DELIMITER //
        CREATE PROCEDURE CalculateTotalBalance(IN userId INT)
        BEGIN
            SELECT
                COALESCE(SUM(balance), 0) AS total_balance
            FROM
                accounts
            WHERE
                user_id = userId;
                AND installement = 0
                AND exclude_from_stats = 0
        END //
        DELIMITER ;
        ";
        DB::query($query);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('GetUserTotalWallet');
    }
};

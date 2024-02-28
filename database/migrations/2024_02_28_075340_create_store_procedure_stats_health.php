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
        CREATE PROCEDURE CalculateHealthing(in userId INT)
        BEGIN
            DECLARE totalAmount DECIMAL(10, 2);

            -- Calcola il total amount sommando la colonna balance per installement = 0
            SELECT COALESCE(SUM(balance), 0)
            INTO totalAmount
            FROM accounts
            WHERE installement = 0 AND user_id = userId AND deleted_at IS NULL AND exclude_from_stats = 0;

            -- Aggiungi alla somma la colonna installementValue per installement = 1
            SELECT COALESCE(SUM(installementValue), 0)
            INTO totalAmount
            FROM accounts
            WHERE installement = 1 AND user_id = userId AND deleted_at IS NULL AND exclude_from_stats = 0;

            -- Restituisci il total amount
            SELECT totalAmount AS total_amount;
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

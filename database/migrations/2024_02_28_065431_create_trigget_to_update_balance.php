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
        CREATE TRIGGER calculate_wallet_balance
        AFTER INSERT ON entries
        FOR EACH ROW
        BEGIN
            DECLARE wallet_total DECIMAL(10, 2);

            -- Calcola il total amount per il wallet corrispondente
            SELECT COALESCE(SUM(amount), 0)
            INTO wallet_total
            FROM entries
            WHERE account_id = NEW.account_id
            AND user_id = NEW.user_id
            AND deleted_at IS NULL
            AND planned = 0
            AND confirmed = 1;

            -- Aggiorna il total amount nella tabella accounts
            UPDATE accounts
            SET balance = wallet_total
            WHERE id = NEW.account_id;
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
        Schema::dropIfExists('calculate_wallet_balance');
    }
};

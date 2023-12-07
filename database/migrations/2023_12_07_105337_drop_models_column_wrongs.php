<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn('transfer');
            $table->dropColumn('confirmed');
            $table->dropColumn('waranty');
            $table->dropColumn('planned');
            $table->dropColumn('model_id');
            $table->dropColumn('payee_id');
            $table->dropColumn('geolocation_id');
            $table->dropColumn('date_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

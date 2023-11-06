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
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->integer('custom')->default(0);
            $table->integer('exclude_from_stats')->default(0);
            $table->integer('user_id')->default(0);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('sorting')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn("custom");
            $table->dropColumn("exclude_from_stats");
            $table->dropColumn("user_id");
        });
    }
};

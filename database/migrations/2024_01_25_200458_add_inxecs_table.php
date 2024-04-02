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
        Schema::table('accounts', function (Blueprint $table) {
            $table->index('workspace_id');
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->index('workspace_id');
        });
        Schema::table('entries', function (Blueprint $table) {
            $table->index('workspace_id');
            $table->index('date_time');
            $table->index('amount');
            $table->index('type');
        });
        Schema::table('labels', function (Blueprint $table) {
            $table->index('workspace_id');
        });
        Schema::table('models', function (Blueprint $table) {
            $table->index('workspace_id');
        });
        Schema::table('payees', function (Blueprint $table) {
            $table->index('workspace_id');
        });
        Schema::table('planned_entries', function (Blueprint $table) {
            $table->index('workspace_id');
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->index('workspace_id');
        });
        Schema::table('user_settings', function (Blueprint $table) {
            $table->index('workspace_id');
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

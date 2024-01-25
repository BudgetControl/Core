<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Reverse the migrations.
     */
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('entries', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('labels', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('models', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('payees', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('planned_entries', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->integer('user_id')->default(0);
        });
        Schema::table('user_settings', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('uuid');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('database_name');
        });
    }
    /**
     * Run the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('entries', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('labels', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('payees', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('planned_entries', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('payments_types', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
        });
    }
};

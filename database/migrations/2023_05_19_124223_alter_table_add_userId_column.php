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
        Schema::table('entries', function (Blueprint $table) {
            $table->integer('workspace_id');
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('workspace_id');
        });

        Schema::table('models', function (Blueprint $table) {
            $table->integer('workspace_id');
        });

        Schema::table('labels', function (Blueprint $table) {
            $table->integer('workspace_id');
        });

        Schema::table('payments_types', function (Blueprint $table) {
            $table->integer('workspace_id');
        });

        Schema::table('payees', function (Blueprint $table) {
            $table->integer('workspace_id');
        });

        Schema::table('geolocation', function (Blueprint $table) {
            $table->integer('workspace_id');
        });

        Schema::table('planned_entries', function (Blueprint $table) {
            $table->integer('workspace_id');
        });
    }
};
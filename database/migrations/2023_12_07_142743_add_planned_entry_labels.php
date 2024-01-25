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
        Schema::create('planned_entry_labels', function (Blueprint $table) {
            $table->id();
            $table->integer('planned_entry_id');
            $table->integer('labels_id');
            $table->timestamps();
            $table->timestamp("date_time")->useCurrent();
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

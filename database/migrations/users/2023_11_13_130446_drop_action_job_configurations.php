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
        Schema::dropIfExists('action_job_configurations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('action_job_configurations', function (Blueprint $table) {
            $table->id();
            $table->string("action");
            $table->text("config");
            $table->timestamps();
            $table->timestamp("date_time")->useCurrent();
        });
    }
};

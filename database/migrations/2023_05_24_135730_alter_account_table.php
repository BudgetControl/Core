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
            $table->timestamp('date')->nullable();
            $table->string('type')->default('Bank');
            $table->boolean('installement')->default(0);
            $table->float('installementValue')->default(0);
            $table->string('currency')->default('EUR');
            $table->float('amount')->default(0);
            $table->float('value')->default(0);
        });
    }
};

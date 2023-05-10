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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email',255)->change();
        });
        
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->string('token',255)->change();
            $table->dropIndex('personal_access_tokens_token_unique');
        });
    }
};
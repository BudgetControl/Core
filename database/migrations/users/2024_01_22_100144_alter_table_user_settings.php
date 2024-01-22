<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_settings', function (Blueprint $table) { 
            $table->dropColumn('currency_id');
            $table->dropColumn('payment_type_id');
            $table->string("setting")->nullable(false);
            $table->json("data")->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->integer("currency_id");
            $table->integer("payment_type_id");
            $table->dropColumn('setting'); 
            $table->dropColumn('data'); 
            $table->timestamps();
        });
    }
};

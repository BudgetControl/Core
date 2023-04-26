<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payees', function (Blueprint $table) {
            $table->id();
            $table->string("uuid");
            $table->string("name");
            $table->timestamps();
            $table->integer("date_time")->nullable();
        });

        // Schema::table('payees', function (Blueprint $table) {
        //     $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payees');
    }
};

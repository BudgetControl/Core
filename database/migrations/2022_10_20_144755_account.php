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
      Schema::create('accounts', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->timestamp("date_time")->useCurrent();
        $table->string("uuid");
        $table->string("name");
        $table->string("color")->default("bg-lightBlue-200 text-lightBlue-600");
        $table->integer('exclude_from_stats')->nullable();
        $table->softDeletes();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('accounts');
    }

};

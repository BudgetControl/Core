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
      Schema::create('sub_categories', function (Blueprint $table) {
        $table->id();
        $table->timestamps();
        $table->timestamp("date_time")->useCurrent();
        $table->string("uuid");
        $table->string("name");
        $table->integer('category_id');
        $table->softDeletes();
      });

      // Schema::table('sub_categories', function (Blueprint $table) {
      //   $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade') ;
      // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
};

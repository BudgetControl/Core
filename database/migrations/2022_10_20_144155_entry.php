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
     Schema::create('entries', function (Blueprint $table) {
       $table->id();
       $table->timestamps();
       $table->timestamp("date_time")->useCurrent();
       $table->string("uuid");
       $table->float("amount");
       $table->text("note")->nullable();
       $table->string("type");
       $table->integer("waranty")->default(0);
       $table->integer("transfer");
       $table->integer('confirmed')->default(0);
       $table->integer('planned')->default(0);

       $table->integer('category_id')->nullable();

       $table->integer('model_id')->nullable();

       $table->integer('account_id');

       $table->integer('transfer_id')->nullable();

       $table->integer('currency_id');

       $table->integer('payment_type')->nullable();

       $table->integer('payee_id')->nullable();

       $table->integer('geolocation_id')->nullable();
       $table->integer('geolocation')->nullable();


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
     Schema::dropIfExists('entries');
   }
};

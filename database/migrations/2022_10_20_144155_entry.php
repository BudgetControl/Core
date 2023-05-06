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

       $table->softDeletes();
     });
     //
     // Schema::table('entries', function (Blueprint $table) {
     //   $table->foreign('category_id')->references('id')->on('sub_categories')->onDelete('cascade');
     //   $table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
     //   $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
     //   $table->foreign('transfer_id')->references('id')->on('accounts');
     //   $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
     //   $table->foreign('payment_type')->references('id')->on('payments_types')->onDelete('cascade');
     //   $table->foreign('payee_id')->references('id')->on('payees')->onDelete('cascade');
     //   $table->foreign('geolocation_id')->references('id')->on('geolocation')->onDelete('cascade');
     // });
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

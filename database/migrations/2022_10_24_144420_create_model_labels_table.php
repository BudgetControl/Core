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
        Schema::create('model_labels', function (Blueprint $table) {
            $table->id();
            $table->integer('models_id');
            $table->integer('labels_id');
            $table->timestamps();
            $table->timestamp("date_time")->useCurrent();
        });

        // Schema::table('model_labels', function (Blueprint $table) {
        //     $table->foreign('models_id')->references('id')->on('models')->onDelete('cascade');
        //     $table->foreign('labels_id')->references('id')->on('labels')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entryes_labels');
    }
};

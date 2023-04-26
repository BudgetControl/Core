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
        Schema::create('entry_labels', function (Blueprint $table) {
            $table->id();
            $table->integer('entry_id');
            $table->integer('labels_id');
            $table->timestamps();
            $table->integer("date_time")->nullable();
        });

        // Schema::table('entry_labels', function (Blueprint $table) {
        //     $table->foreign('entry_id')->references('id')->on('entries')->onDelete('cascade');
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

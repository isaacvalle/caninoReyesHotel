<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ZealHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zealHistories', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->date('date');
            $table->string('observations');
            $table->unsignedMediumInteger('dogId');
            $table->foreign('dogId')->references('id')->on('dogs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zealHistories');
    }
}

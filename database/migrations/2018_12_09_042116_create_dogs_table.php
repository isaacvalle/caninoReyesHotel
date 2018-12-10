<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('name', 100);
            $table->unsignedTinyInteger('breedId');
            $table->binary('gender');
            $table->string('picture', 200)->nullable();
            $table->date('dob');
            $table->unsignedTinyInteger('colorId');
            $table->unsignedTinyInteger('spotsColorId');
            $table->tinyInteger('size');
            $table->tinyInteger('weight')->nullable();
            $table->binary('sterialized');
            $table->date('lastZeal')->nullable();
            $table->binary('specialCare')->nullable();
            $table->text('descSpecialCare', 150)->nullable();
            $table->binary('status');
            $table->time('lunchTime');
            $table->binary('friendly');
            $table->text('observations')->nullable();
            $table->unsignedMediumInteger('userId');
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('breedId')->references('id')->on('breeds');
            $table->foreign('colorId')->references('id')->on('colors');
            $table->foreign('spotsColorId')->nullable()->references('id')->on('colors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dogs');
    }
}

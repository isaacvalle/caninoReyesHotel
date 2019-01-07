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
            $table->engine = 'InnoDB';
            $table->mediumIncrements('id');
            $table->string('name', 100);
            $table->unsignedTinyInteger('breed_id');
            $table->binary('gender');
            $table->string('picture', 200)->nullable();
            $table->date('dob');
            $table->unsignedTinyInteger('color_id');
            $table->unsignedTinyInteger('spots_color_id')->nullable();
            $table->unsignedTinyInteger('size_id');
            $table->tinyInteger('weight')->nullable();
            $table->binary('sterialized');
            $table->date('last_zeal')->nullable();
            $table->binary('special_care')->nullable();
            $table->text('desc_special_care', 150)->nullable();
            $table->binary('status');
            $table->time('lunch_time');
            $table->binary('friendly');
            $table->text('observations')->nullable();
            $table->unsignedMediumInteger('user_id');
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('breed_id')->references('id')->on('breeds');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('spots_color_id')->references('id')->on('colors');
            $table->foreign('size_id')->references('id')->on('size_categories');
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Address extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->unsignedMediumInteger('streetId');
            $table->unsignedSmallInteger('localityId');
            $table->unsignedSmallInteger('municipalityId');
            $table->unsignedTinyInteger('stateId');
            $table->string('reference');
            $table->smallInteger('zipCode');
            $table->string('mapsLocation');
            $table->unsignedMediumInteger('userId');
            $table->foreign('streetId')->references('id')->on('streets');
            $table->foreign('localityId')->references('id')->on('localities');
            $table->foreign('stateId')->references('id')->on('states');
            $table->foreign('municipalityId')->references('id')->on('municipalities');
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}

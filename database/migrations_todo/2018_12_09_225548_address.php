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
            $table->engine = 'InnoDB';
            $table->mediumIncrements('id');
            $table->string('number');
            $table->string('int_number')->nullable();
            $table->unsignedMediumInteger('street_id');
            $table->unsignedSmallInteger('locality_id');
            $table->unsignedSmallInteger('municipality_id');
            $table->unsignedTinyInteger('state_id');
            $table->string('reference');
            $table->unsignedSmallInteger('zip_code_id');
            $table->string('mapsLocation');
            $table->timestamps();

            $table->foreign('street_id')
                  ->references('id')
                  ->on('streets');

            $table->foreign('locality_id')
                  ->references('id')
                  ->on('localities');

            $table->foreign('state_id')
                  ->references('id')
                  ->on('states');

            $table->foreign('municipality_id')
                  ->references('id')
                  ->on('municipalities');

            $table->foreign('zip_code_id')
                  ->references('id')
                  ->on('zip_codes');
            
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

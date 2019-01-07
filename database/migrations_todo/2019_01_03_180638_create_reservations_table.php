<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedMediumInteger('user_id');
            $table->unsignedMediumInteger('dog_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->unsignedTinyInteger('service_id');
            $table->unsignedTinyInteger('status_id');
            $table->unsignedTinyInteger('room_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');

            $table->foreign('dog_id')
                   ->references('id')
                   ->on('dogs');

            $table->foreign('service_id')
                  ->references('id')
                  ->on('services');

            $table->foreign('status_id')
                   ->references('id')
                   ->on('reservation_statuses');

            $table->foreign('room_id')
                   ->references('id')
                   ->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}

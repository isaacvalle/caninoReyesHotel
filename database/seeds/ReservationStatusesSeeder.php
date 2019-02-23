<?php

use Illuminate\Database\Seeder;

use App\Models\ReservationStatus;
class ReservationStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// ReservationStatus::truncate();

    	ReservationStatus::create([
    		'name' => 'reserved',
    		'description' => 'just reserved waiting for the service'
    	]);

    	ReservationStatus::create([
    		'name' => 'in progress',
    		'description' => 'the service is currently in progress'
    	]);

    	ReservationStatus::create([
    		'name' => 'stopped',
    		'description' => 'the reservation has started but something went wgron so the reservation is waiting'
    	]);

    	ReservationStatus::create([
    		'name' => 'canceled',
    		'description' => 'the reservation was canceled before it start'
    	]);

    	ReservationStatus::create([
    		'name' => 'finished',
    		'description' => 'the reservation has end'
    	]);
    }
}

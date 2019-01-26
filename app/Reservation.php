<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
	protected $primaryKey = 'id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'dog_id', 'start_date', 'end_date', 'service_id', 'status_id', 'room_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * Get the dog's reservation.
     */
    public function dog(){
        return $this->hasOne('App\Dog', 'id', 'dog_id');
    }

    /**
     * Get the reservation service.
     */
    public function service(){
        return $this->hasMany('App\Service', 'id', 'service_id');
    }

    /**
     * Get the reservation status.
     */
    public function status(){
        return $this->hasOne('App\ReservationStatus', 'id', 'status_id');
    }

    /**
     * Get the dog breed.
     */
    public function room(){
        return $this->hasOne('App\Room', 'id', 'room_id');
    }
}

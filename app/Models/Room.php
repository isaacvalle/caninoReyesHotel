<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
	protected $primaryKey = 'id';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'status', 'description', 'category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * Get the rooms by cetegory.
     */
    public function categories() {
        return $this->hasMany('App\Models\RoomCategory', 'id', 'category_id');
    }

    /**
     * Get the dogs for the breed.
     */
    public function reservations() {
    	return $this->hasMany('App\Models\Reservation', 'id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
	protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'int_number', 'street_id', 'locality_id', 'municipality_id', 'state_id', 'reference', 'zip_code_id', 'maps_location'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * Get the address street.
     */
    public function street() {
    	return $this->hasOne('App\Models\Street', 'id');
    }

    /**
     * Get the address locality.
     */
    public function locality() {
    	return $this->hasOne('App\Models\Locality', 'id');
    }

    /**
     * Get the address municipality.
     */
    public function municipality() {
    	return $this->hasOne('App\Models\Municipality', 'id');
    }

    /**
     * Get the address state.
     */
    public function state() {
    	return $this->hasOne('App\Models\State', 'id');
    }

    /**
     * Get the address zip_code.
     */
    public function zip_code() {
    	return $this->hasOne('App\Models\ZipCode', 'id');
    }
}

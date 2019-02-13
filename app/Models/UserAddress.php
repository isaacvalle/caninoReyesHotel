<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'users_addresses';
	protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'address_id'
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
    public function address() {
    	//change to hasMany in case one user has more than one address
    	return $this->hasOne('App\Models\Address', 'id', 'address_id');
    }
}

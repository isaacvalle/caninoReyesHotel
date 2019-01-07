<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
	protected $table = 'breeds';
	protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * Get the dogs for the breed.
     */
    public function dogs() {
    	return $this->belongsTo('App\Dog', 'id', 'id');
    }
}

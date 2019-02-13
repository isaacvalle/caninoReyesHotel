<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeightHistory extends Model
{
    protected $table = 'weight_histories';
	protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'weight', 'dog_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * Get the dog weight.
     */
    public function weight() {
    	return $this->belongsTo('App\Models\Dog', 'id');
    }
}

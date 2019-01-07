<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZealHistory extends Model
{
    protected $table = 'zeal_histories';
	protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'observations', 'dog_id'
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
    public function zeal() {
    	return $this->belongsTo('App\Dog', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SizeCategory extends Model
{
    protected $table = 'size_categories';
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
     * Get the dogs for the size.
     */
    public function dogs() {
    	return $this->belongsTo('App\Dog', 'id', 'id');
    }
}

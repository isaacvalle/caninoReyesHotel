<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{

	protected $table = 'dogs';
	protected $primaryKey = 'id';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name',
                            'breed_id', 
                            'gender', 
                            'picture', 
                            'dob',
                            'color_id',
                            'spots_color_id',
                            'size_id',
                            'weight',
                            'sterialized',
                            'last_zeal',
                            'special_care',
                            'desc_special_care',
                            'status',
                            'lunch_time',
                            'friendly',
                            'observations',
                            'user_id' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * Get the dog breed.
     */
    public function breed(){
        return $this->hasOne('App\Models\Breed', 'id', 'breed_id');
    }

    /**
     * Get the dog color.
     */
    public function color(){
        return $this->hasOne('App\Models\Color', 'id', 'color_id');
    }

    /**
     * Get the dog spots color.
     */
    public function spots_color(){
        return $this->hasOne('App\Models\Color', 'id', 'spots_color_id');
    }

    /**
     * Get the dog color.
     */
    public function size(){
        return $this->hasOne('App\Models\SizeCategory', 'id', 'size_id');
    }

    /**
     * Get the dog zeal history.
     */
    public function zeal_history(){
        return $this->hasMany('App\Models\ZealHistory', 'id');
    }

    /**
     * Get the dog zeal history.
     */
    public function weight_history(){
        return $this->hasMany('App\Models\WeightHistory', 'id');
    }
}

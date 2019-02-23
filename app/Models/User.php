<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'mother_last_name', 'phone', 'mobile', 'email', 'password', 'picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Get the user's dogs.
     */
    public function dogs(){
        return $this->hasMany('App\Models\Dog');
    }

    /**
     * To generate a token
     *
     * @return token
     */
    /*public function generateToken() {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }*/
}

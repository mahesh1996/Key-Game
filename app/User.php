<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isStarted(){
        if( ! is_null($this->started_on) ) 
            return true;
        else 
            return false;
    }

    public function isFinished(){
        if($this->isStarted() && ! is_null($this->ended_on)) 
            return true;
        else 
            return false;
    }
}

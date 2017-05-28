<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions () {
        return $this->hasMany('App\Question', 'owner', 'id');
    }

    public function answers () {
        return $this->hasMany('App\Answer', 'owner', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{
    protected $fillable = ['owner', 'category_id', 'text', 'solved', 'city_id'];

    protected $rules = [
        'text' => 'required|min:3|max:2500',
    ];

    function answers()
    {
        return $this->hasMany('App\Answer');
    }

    function userAnswered ($user_id) {
        return !$this->answers->filter(function ($answer) use ($user_id) {
            return $user_id == $answer->owner;
        })->isEmpty();
    }
}

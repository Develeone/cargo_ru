<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = ['owner', 'question_id', 'text', 'email', 'phone'];

    protected $rules = [
        'text' => 'required|min:3|max:500',
        'email' => 'min:3|max:150',
        'phone' => 'min:3|max:150',
    ];

    function question()
    {
        return $this->hasOne('App\Question', 'id', 'question_id');
    }

    function get_owner()
    {
        return $this->hasOne('App\User', 'id', 'owner');
    }

    public function save (array $options = []) {
        $saveResult = parent::save($options);

        $question = $this->question()
            ->with('answers')
            ->first();

        return $saveResult;
    }

}

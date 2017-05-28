<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = ['owner', 'question_id', 'text'];

    protected $rules = [
        'text' => 'required|min:3|max:2000',
    ];

    function question()
    {
        return $this->hasOne('App\Question', 'id', 'question_id');
    }

    public function save (array $options = []) {
        $saveResult = parent::save($options);

        $question = $this->question()
            ->with('answers')
            ->first();

        return $saveResult;
    }

}

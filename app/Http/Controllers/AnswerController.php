<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    function create (Request $request) {
        $question = Question::where('id', $request->question_id)
            ->with('answers')
            ->first();

        if ($question->owner == Auth::id() || $question->solved || $question->userAnswered(Auth::id()))
            return abort(403);

        $newAnswer = new Answer($request->all());
        Auth::user()->answers()->save($newAnswer);

        if ($question->answers->count() == 9) // WAS! 9, now it's 10!
            $question->update(['solved' => true]);

        return $question->id;
    }
}

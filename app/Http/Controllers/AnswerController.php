<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    const MAX_ANSWERS = 15;

    function create (Request $request) {
        $question = Question::where('id', $request->question_id)
            ->with('answers')
            ->first();

        if ($question->owner == Auth::id() || $question->solved || $question->userAnswered(Auth::id()))
            return abort(403);

        $newAnswer = new Answer($request->all());
        Auth::user()->answers()->save($newAnswer);

        if ($question->answers->count() == MAX_ANSWERS-1)
            $question->update(['solved' => true]);

        return $question->id;
    }

    function getContacts ($answer_id) {
        $answer_contacts = Answer::select("email", "phone")
            ->where('id', $answer_id)
            ->first();

        return json_encode($answer_contacts);
    }
}

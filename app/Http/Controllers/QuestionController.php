<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    function show ($questionId) {
        return Question::where('id', $questionId)
            ->with('answers')
            ->first();
    }

    function create (Request $request) {
        $newQuestion = new Question($request->all());

        Auth::user()->questions()->save($newQuestion);

        return response("Ok");
    }
}

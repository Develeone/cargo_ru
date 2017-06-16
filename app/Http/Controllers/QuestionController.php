<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReCaptcha\ReCaptcha;

class QuestionController extends Controller
{
    function show ($questionId) {
        return Question::where('id', $questionId)
            ->with('answers')
            ->first();
    }

    function create (Request $request) {
        $response = $request->get('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret   = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);

        if ($resp->isSuccess()) {
            abort(403);//return "YEAH";
        } else {
            abort(402);//return "none :(";
        }

        $newQuestion = new Question($request->all());

        Auth::user()->questions()->save($newQuestion);

        return response("Ok");
    }
}

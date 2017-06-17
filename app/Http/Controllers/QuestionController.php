<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Auth\Access\Response;
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
        $this->validate($request, [
            'text' => 'required|min:2|max:500'
        ]);

        $response = $request->get('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret   = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);

        if (!$resp->isSuccess())
            return response("Необходимо выполнить проверку CAPTCHA", 403);

        $newQuestion = new Question($request->all());

        Auth::user()->questions()->save($newQuestion);

        return response("Ok");
    }
}

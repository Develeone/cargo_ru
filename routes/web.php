<?php


Route::get('/', 'PageController@index');

Route::get('/question/{id}', 'QuestionController@show');
Route::post('/question/new', 'QuestionController@create');

Route::post('/answer/new', 'AnswerController@create');

Auth::routes();


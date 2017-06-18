<?php


Route::get('/', 'PageController@index');

Route::get('/ads', 'PageController@adsPage');
Route::get('/admin', 'PageController@adminPage');

Route::get('/category/{id}/getContent', 'CategoryController@getContent');

Route::get('/question/{id}', 'QuestionController@show');
Route::post('/question/new', 'QuestionController@create');

Route::post('/answer/new', 'AnswerController@create');
Route::get('/answer/{id}/getContacts', 'AnswerController@getContacts');

Auth::routes();


<?php


Route::get('/', 'PageController@index');

Route::get('/ads', 'PageController@adsPage');
Route::get('/admin', 'PageController@adminPage');

Route::get('/category/{id}/getContent', 'CategoryController@getContent');

Route::get('/category/{id}/getGeoParams', 'CategoryController@getGeoParams');

Route::get('/question/{id}', 'QuestionController@show');
Route::post('/question/new', 'QuestionController@create');

Route::post('/answer/new', 'AnswerController@create');
Route::get('/answer/{id}/getContacts', 'AnswerController@getContacts');

Route::get('/geo/getRegionsByCountryId/{id}', "GeoController@getRegionsByCountryId");
Route::get('/geo/getCitiesByRegionId/{id}', "GeoController@getCitiesByRegionId");

Auth::routes();


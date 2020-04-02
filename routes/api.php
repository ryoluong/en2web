<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'Api\Auth\LoginController@login');
Route::post('/logout', 'Api\Auth\LoginController@logout');
Route::post('/refresh', 'Api\Auth\LoginController@refresh');
Route::get('/me', 'Api\Auth\LoginController@me');

Route::get('/notes', 'Api\NotesController@index');
Route::get('/notes/categories', 'Api\NotesController@categories');
Route::get('/notes/tags', 'Api\NotesController@tags');
Route::get('/notes/{note}', 'Api\NotesController@get');
Route::post('/notes/{note}', 'Api\NotesController@update');
Route::delete('/notes/{note}', 'Api\NotesController@delete');
Route::post('/notes/create', 'Api\NotesController@create');
Route::put('/notes/{note}/fav', 'Api\NotesController@fav');

Route::get('/users', 'Api\UsersController@index');
Route::get('/users/{user}', 'Api\UsersController@get');

Route::get('/countries', 'Api\CountriesController@index');

// Webhooks
Route::post('/webhook/line', 'LineApiController@response');
Route::post('/slack/command', 'SlackController@command');
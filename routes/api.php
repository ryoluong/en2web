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

Route::post('/register', 'Api\Auth\RegisterController@register');
Route::post('/register/verify', 'Api\Auth\RegisterController@verify');

Route::get('/notes', 'Api\NotesController@index');
Route::get('/notes/{note}', 'Api\NotesController@get')->where('note', '[0-9]+');
Route::post('/notes', 'Api\NotesController@store');
Route::put('/notes/{note}', 'Api\NotesController@update')->where('note', '[0-9]+');
Route::delete('/notes/{note}', 'Api\NotesController@destroy')->where('note', '[0-9]+');
Route::put('/notes/{note}/fav', 'Api\NotesController@fav')->where('note', '[0-9]+');

Route::get('/notes/categories', 'Api\NotesController@categories');
Route::get('/notes/tags', 'Api\NotesController@tags');

Route::get('/users', 'Api\UsersController@index');
Route::get('/users/{user}', 'Api\UsersController@get');
Route::patch('/users/update', 'Api\UsersController@update');
Route::post('/users/upload', 'Api\UsersController@upload');
Route::post('/users/icon', 'Api\UsersController@saveIcon');

Route::get('/countries', 'Api\CountriesController@index');

// Webhooks
Route::post('/webhook/line', 'LineApiController@response');
Route::post('/slack/command', 'SlackController@command');
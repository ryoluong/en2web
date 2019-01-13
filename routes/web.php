<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * En2 HomePage
 */
Route::get('/', function () { return view('auth.login'); });//return view('hp.index'); });
Route::get('/login', function() { return view('auth.login'); });
// Route::get('/about_us', function () { return view('hp.about_us'); });
// Route::get('/study_abroad', function () { return view('hp.study_abroad'); });
// Route::get('/activities', function () { return view('hp.activities'); });
// Route::get('/achievements', function () { return view('hp.achievements'); });
// Route::get('/join_contact', function () { return view('hp.join_contact'); });

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'UserController@showHome');
    Route::get('/mypage', 'UserController@showMyPage');
    Route::get('/mypage/edit', 'UserController@editMyPage');
    Route::patch('/mypage/update', 'UserController@updateMyPage');

    /**
     * Users
     */
    Route::resource('users', 'UsersController', ['only' => ['index','show']]);

    /**
     * Countries
     */
    Route::resource('countries', 'CountriesController', ['only' => ['index','show']]);

    /**
     * Notes
     */
    //resource
    Route::resource('notes', 'NotesController');
    //create
    Route::post('/notes/create', 'NotesController@confirm');
    //show
    Route::get('/all/notes', 'NotesController@showAll');
    Route::get('/best/notes', 'NotesController@showBest');
    Route::get('/categories/{category}/notes', 'NotesController@showByCategory');
    Route::get('/tags/{tag}/notes', 'NotesController@showByTag');
    Route::get('/users/{user}/notes', 'NotesController@showByAuthor');
    Route::get('/countries/{country}/notes', 'NotesController@showByCountry');
    //edit
    Route::post('/notes/{note}/edit', 'NotesController@editConfirm');
    //delete
    Route::get('/notes/{note}/delete', 'NotesController@deleteConfirm');
});

/**
 * Auth and Register
 */
Auth::routes();
Route::post('register/confirm', 'Auth\RegisterController@confirm')->name('register.confirm');
Route::post('register/confirm/existinguser', 'Auth\RegisterController@registerExistingUser')->name('register.existing.user');
Route::get('register/verify/{token}', 'Auth\RegisterController@showForm');
Route::post('register/main_confirm', 'Auth\RegisterController@mainCheck')->name('register.main.confirm');
Route::post('register/main_register', 'Auth\RegisterController@mainRegister')->name('register.main.registered');

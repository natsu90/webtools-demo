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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/patients', 'PatientController@index');
Route::get('/patients/{id}', 'PatientController@edit');
Route::get('/patient/new', 'PatientController@create');
Route::post('/patient', 'PatientController@store');
Route::post('/patients/{id}', 'PatientController@update');

Route::post('/patients/{id}/note', 'NoteController@store');
Route::post('/notes/{id}', 'NoteController@update');
Route::get('/patients/{id}/new-note', 'NoteController@create');
Route::get('/notes/{id}', 'NoteController@edit');

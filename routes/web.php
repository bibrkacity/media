<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['namespace' => '\App\Http\Controllers\Citations', 'middleware'=>'auth'], function () {

    Route::get('/', 'CitationController@index')->name('home');

});


Route::group(['namespace' => '\App\Http\Controllers\Auth'], function () {

    Route::get('registration', 'RegisterController@form')->name('registration');

    Route::post('registration', 'RegisterController@submit')->name('registration.submit');

    Route::get('login', 'LoginController@form')->name('login');

    Route::post('login', 'LoginController@submit')->name('login.submit');

});

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

Route::get('/',  function () {
    return view('home');
})->middleware('auth')->name('home');

Route::group(['prefix'=>'citations','namespace' => '\App\Http\Controllers\Citations', 'middleware'=>'auth'], function () {

    Route::get('create', 'CitationController@create')->name('citations.create');
    Route::get('/{per_page?}', 'CitationController@index')->name('citations.index');
    Route::post('/', 'CitationController@store')->name('citations.store');
    Route::get('{id}/edit', 'CitationController@edit')->name('citations.edit');
    Route::put('{id}', 'CitationController@update')->name('citations.update');
});

Route::group(['namespace' => '\App\Http\Controllers\Auth'], function () {

    Route::get('registration', 'RegisterController@form')->name('registration');

    Route::post('registration', 'RegisterController@submit')->name('registration.submit');

    Route::get('login', 'LoginController@form')->name('login');

    Route::post('login', 'LoginController@submit')->name('login.submit');

});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1','namespace'=>'\App\Http\Controllers\Api\V1'], function ($api) {

    $api->post('register', 'Auth\RegisterController@register')->name('api.register.v1');
    $api->post('login', 'Auth\LoginController@login')->name('api.login.v1');

    Route::group(['middleware'=>'auth:sanctum'], function ($api) {

        $api->get('user', function (Request $request) {
            return $request->user();
        });

        Route::group(['prefix'=>'citations'], function ($api) {

            $api->get('/' , 'Citations\CitationController@index')->name('api.citations.index');
            $api->post('/', 'Citations\CitationController@store')->name('api.citations.store');
            $api->put('/' , 'Citations\CitationController@update')->name('api.citations.update');
            $api->post('/send', 'Citations\CitationController@send')->name('api.citations.send');
            $api->get('/messengers' , 'Citations\CitationController@messengers')->name('api.citations.messengers');
        });

    });

});


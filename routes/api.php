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

            $api->get('/', 'CitationController@index')->name('citations.index');
            $api->post('/', 'CitationController@store')->name('citations.store');
            $api->put('/', 'CitationController@update')->name('citations.update');

        });

    });

});


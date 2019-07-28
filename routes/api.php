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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'books'], function () {
	Route::post('', 'BookController@store');
	Route::patch('{book}', 'BookController@update');
	Route::delete('{book}', 'BookController@delete');
});


Route::group(['prefix' => 'authors'], function () {
	Route::post('', 'AuthorController@store');
});
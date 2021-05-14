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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers'], function(){

	Route::get('/stop-window/{window_id}', [
		'as' => 'api.stop.window',
		'uses' => 'ApiController@stopWindow'
	]);

	Route::get('/send-stop', [
		'as' => 'api.send.stop',
		'uses' => 'ApiController@sendStop'
	]);

	Route::get('/get-comments/{call_id}', [
		'as' => 'api.comments.get',
		'uses' => 'ApiController@getComments'
	]);

	Route::post('/save-comments', [
		'as' => 'api.comments.save',
		'uses' => 'ApiController@saveComments'
	]);

});

//////////////// TEST ////////////////////

Route::group(['namespace' => 'App\Http\Controllers\Tests'], function(){

	Route::get('/get-test', [
		'as' => 'test.data',
		'uses' => 'TestController@data'
	]);

	Route::post('/send1-test', [
		'as' => 'test.send1',
		'uses' => 'TestController@send1'
	]);

	Route::post('/send2-test', [
		'as' => 'test.send2',
		'uses' => 'TestController@send2'
	]);

	Route::post('/send3-test', [
		'as' => 'test.send3',
		'uses' => 'TestController@send3'
	]);

});
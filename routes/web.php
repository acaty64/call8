<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'is_admin', 'namespace' => 'App\Http\Controllers'], function(){

	require __DIR__ . '/admin.php';

});
/////////////////// STOP DASHBOARD ROUTES //////////////////


/////////////////// START VIDEO-CHAT ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){

	Route::get('/video_chat/{user_id}/{other_id}/{call_id}', [
		'as' => 'app.video_chat',
		'uses' => 'VideoChatController@index'
	]);

	Route::post('/auth/video_chat', [
		'as' => 'auth.video-chat',
		// 'uses' => 'VideoChatController@auth'
		'uses' => 'VideoChatController@auth'
	]);
});
/////////////////// STOP VIDEO-CHAT ROUTES //////////////////


/////////////////// CALL ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){

	Route::get('/call/client', [
		'as' => 'call.client',
		'uses' => 'CallController@client'
	]);

	Route::get('/call/host', [
		'as' => 'call.host',
		'uses' => 'CallController@host'
	]);

});
/////////////////// END CALL ROUTES //////////////////


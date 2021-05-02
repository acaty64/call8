<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/////////////////// START VIDEO-CHAT ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){
	Route::get('/video_chat/test', [
		'as' => 'video_chat',
		'uses' => 'VideoChatController@index_0'
	]);

	Route::post('/auth/video_chat_0', [
		'as' => 'auth.video-chat_0',
		'uses' => 'VideoChatController@auth_0'
	]);
});
/////////////////// STOP VIDEO-CHAT ROUTES //////////////////

/////////////////// START LIVEWIRE VIDEO-CHAT ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){
	Route::get('/livewire/video_chat', [
		'as' => 'livewire.video_chat',
		'uses' => 'VideoChatController@index'
	]);

	Route::get('/livewire1/video_chat/{user_id}/{other_id}', [
		'as' => 'livewire.video_chat',
		'uses' => 'VideoChatController@index1'
	]);

	Route::post('/auth/video_chat', [
		'as' => 'auth.video-chat',
		// 'uses' => 'VideoChatController@auth'
		'uses' => 'VideoChatController@auth'
	]);
});
/////////////////// STOP VIDEO-CHAT ROUTES //////////////////



/////////////////// START TESTS ROUTES //////////////////
Route::get('/tests', function () {
    return view('tests.tests')->with(['user' => Auth::user()]);
});

Route::get('/pusher/tests', function () {
    return view('tests.Pusher_test');
});

/////////////////// STOP TESTS ROUTES //////////////////

/////////////////// START USER ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){

	Route::get('/users/index', [
		'as' => 'users.index',
		'uses' => 'UserController@index'
	]);

	Route::get('/user/create', [
		'as' => 'user.create',
		'uses' => 'UserController@create'
	]);

	Route::post('/user/store', [
		'as' => 'user.store',
		'uses' => 'UserController@store'
	]);

	Route::get('/user/{id}/edit', [
		'as' => 'user.edit',
		'uses' => 'UserController@edit'
	]);

	Route::post('/user/update', [
		'as' => 'user.update',
		'uses' => 'UserController@update'
	]);

	Route::delete('/user/destroy/{id}', [
		'as' => 'user.destroy',
		'uses' => 'UserController@destroy'
	]);

});

/////////////////// END USER ROUTES //////////////////


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

	Route::get('/call/index', [
		'as' => 'call.index',
		'uses' => 'CallController@index'
	]);


});
/////////////////// END CALL ROUTES //////////////////

/////////////////// WINDOW ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){

	Route::get('/window/index', [
		'as' => 'window.index',
		'uses' => 'WindowController@index'
	]);


});
/////////////////// END CALL ROUTES //////////////////

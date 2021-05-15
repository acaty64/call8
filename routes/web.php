<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
/////////////////// GOOGLE LOGIN //////////////////

// Redirigir al usuario hacia Google
Route::get('/login/google', [App\Http\Controllers\Auth\LoginGoogleController::class, 'redirect']);

// Gestionar la respuesta de Google
Route::get('/login/callback', [App\Http\Controllers\Auth\LoginGoogleController::class,'callback']);


/////////////////// END GOOGLE LOGIN //////////////////




Route::group(['middleware' => 'is_admin', 'namespace' => 'App\Http\Controllers'], function(){

	require __DIR__ . '/admin.php';

});

Route::group(['middleware' => 'is_host', 'namespace' => 'App\Http\Controllers'], function(){

	require __DIR__ . '/host.php';

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/////////////////// START VIDEO-CHAT ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){

Route::get('/test_route', function ()
{
	dd('Ruta auth en web.php');
} );


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

});
/////////////////// END CALL ROUTES //////////////////


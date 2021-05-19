<?php

use App\Http\Controllers\Auth\LoginGoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	if(env('APP_DEBUG')){
		return redirect(route('login'));
	}
	return redirect(route('login.google'));
});

Auth::routes();
/////////////////// GOOGLE LOGIN //////////////////

// Redirigir al usuario hacia Google
Route::get('/login/google', [
		'as' => 'login.google',
		'uses' => 'LoginGoogleController@redirect'
	]);

// Gestionar la respuesta de Google
Route::get('/login/callback', [App\Http\Controllers\Auth\LoginGoogleController::class, 'callback']);

// Route::get('/login/callback', [
// 		'as' => 'google.callback',
// 		'uses' => 'LoginGoogleController@callback'
// 	]);


/////////////////// END GOOGLE LOGIN //////////////////


/////////////////// ACCESS ROUTES //////////////////
Route::group(['middleware' => 'is_master', 'namespace' => 'App\Http\Controllers'], function(){

	require __DIR__ . '/master.php';

});

Route::group(['middleware' => 'is_admin', 'namespace' => 'App\Http\Controllers'], function(){

	require __DIR__ . '/admin.php';

});

Route::group(['middleware' => 'is_host', 'namespace' => 'App\Http\Controllers'], function(){

	require __DIR__ . '/host.php';

});
/////////////////// end ACCESS ROUTES //////////////////

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


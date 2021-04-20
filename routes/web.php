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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


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

	Route::get('/call', [
		'as' => 'call.screen',
		'uses' => 'CallController@screen'
	]);

	Route::get('/call/index', [
		'as' => 'call.index',
		'uses' => 'CallController@index'
	]);

	Route::post('/call/store', [
		'as' => 'call.store',
		'uses' => 'CallController@store'
	]);

	Route::post('/call/close', [
		'as' => 'call.close',
		'uses' => 'CallController@close'
	]);

});
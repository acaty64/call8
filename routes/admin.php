<?php

use Illuminate\Support\Facades\Route;


Route::get('/schedule', [
	'as' => 'schedule',
	'uses' => 'ScheduleController@index'
]);

Route::get('/schedule/crud', [
	'as' => 'schedule.crud',
	'uses' => 'ScheduleController@crud',
]);

Route::get('/dashboard', [
	'as' => 'app.dashboard',
	'uses' => 'DashboardController@index'
]);

Route::get('/windows/index', [
	'as' => 'windows.index',
	'uses' => 'WindowController@index'
]);

//////////// USER

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


//////////// CALL
Route::get('/calls/index', [
	'as' => 'calls.index',
	'uses' => 'CallController@index'
]);


//////////// LINK
Route::get('/links/index', [
	'as' => 'links.index',
	'uses' => 'LinkController@index'
]);


Route::get('/tests', function () {
    return view('tests.tests')->with(['user' => Auth::user()]);
});

Route::get('/pusher/tests', function () {
    return view('tests.Pusher_test');
});
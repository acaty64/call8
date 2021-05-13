<?php

use Illuminate\Support\Facades\Route;


Route::get('/schedule', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedule');

Route::get('/schedule/crud', [App\Http\Controllers\ScheduleController::class, 'crud'])->name('schedule.crud');






/////////////////// START DASHBOARD ROUTES //////////////////
Route::group(['middleware' => 'auth', 'namespace' => 'App\Http\Controllers'], function(){

	Route::get('/dashboard', [
		'as' => 'app.dashboard',
		'uses' => 'DashboardController@index'
	]);

});
/////////////////// STOP DASHBOARD ROUTES //////////////////



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

<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin/menu', [
	'as' => 'admin.menu',
	'uses' => 'MenuController@admin'
]);

Route::get('/access/index', [
	'as' => 'access.index',
	'uses' => 'AccessController@index'
]);

Route::get('/schedule', [
	'as' => 'schedule',
	'uses' => 'ScheduleController@index'
]);

Route::get('/schedule/crud', [
	'as' => 'schedule.crud',
	'uses' => 'ScheduleController@crud',
]);

Route::get('/dashboard', [
	'as' => 'dashboard',
	'uses' => 'DashboardController@index'
]);

Route::post('/statistics/chart', [
	'as' => 'statistics.chart',
	'uses' => 'ChartController@statistics'
]);

Route::get('/statistics/index', [
	'as' => 'statistics.index',
	'uses' => 'ChartController@index'
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

// Route::get('/user/create', [
// 	'as' => 'user.create',
// 	'uses' => 'UserController@create'
// ]);

// Route::post('/user/store', [
// 	'as' => 'user.store',
// 	'uses' => 'UserController@store'
// ]);

// Route::get('/user/{id}/edit', [
// 	'as' => 'user.edit',
// 	'uses' => 'UserController@edit'
// ]);

// Route::post('/user/update', [
// 	'as' => 'user.update',
// 	'uses' => 'UserController@update'
// ]);

// Route::delete('/user/destroy/{id}', [
// 	'as' => 'user.destroy',
// 	'uses' => 'UserController@destroy'
// ]);


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

//////////// COMMENTS
Route::get('/comments/index', [
	'as' => 'comments.index',
	'uses' => 'CommentController@index'
]);

//////////// DOCUMENTS

Route::get('/documents/index', [
	'as' => 'documents.index',
	'uses' => 'DocumentController@index'
]);

Route::get('/document/create', [
	'as' => 'document.create',
	'uses' => 'DocumentController@create'
]);

Route::post('/document/store', [
	'as' => 'document.store',
	'uses' => 'DocumentController@store'
]);

Route::get('/document/{id}/edit', [
	'as' => 'document.edit',
	'uses' => 'DocumentController@edit'
]);

Route::post('/document/update', [
	'as' => 'document.update',
	'uses' => 'DocumentController@update'
]);

Route::get('/document/{id}/show', [
	'as' => 'document.show',
	'uses' => 'DocumentController@show'
]);

Route::get('/document/destroy/{id}', [
	'as' => 'document.destroy',
	'uses' => 'DocumentController@destroy'
]);

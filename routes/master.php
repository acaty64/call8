<?php

use Illuminate\Support\Facades\Route;


Route::get('/office/index', [
	'as' => 'office.index',
	'uses' => 'OfficeController@index'
]);
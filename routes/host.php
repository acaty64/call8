<?php

use Illuminate\Support\Facades\Route;

Route::get('/call/host', [
	'as' => 'call.host',
	'uses' => 'CallController@host'
]);



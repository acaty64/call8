<?php

use Illuminate\Support\Facades\Route;

Route::get('/call/host', [
	'as' => 'call.host',
	'uses' => 'CallController@host'
]);

Route::get('/stop/host', [
	'as' => 'stop.host',
	'uses' => 'WindowController@stop'
]);



<?php

use Illuminate\Support\Facades\Route;


Route::get('/office/index', [
	'as' => 'office.index',
	'uses' => 'OfficeController@index'
]);

Route::get('/master/menu', [
	'as' => 'master.menu',
	'uses' => 'MenuController@master'
]);

Route::get('/master/menu', [
	'as' => 'master.menu',
	'uses' => 'MenuController@master'
]);

Route::get('/test/vue', function () {
    return view('tests.test_vue')->with(['user' => \Auth::user()]);
});

Route::get('/test/livewire', function () {
    return view('tests.test_livewire')->with(['user' => \Auth::user()]);
});

Route::get('/pusher/tests', function () {
    return view('tests.Pusher_test');
});


Route::get('/chart/test', [App\Http\Controllers\ChartController::class, 'test'])->name('chart.test');

Route::get('/web-rtc', function () {
	return view('tests.webrtc_tests');
});

Route::get('/php', function () {
	return view('welcome');
});

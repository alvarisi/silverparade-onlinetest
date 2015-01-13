<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/cek',function(){
	$numbers = range(1, 10);
    shuffle($numbers);
    $arr = array_slice($numbers, 0, 10);
	echo "<pre>";
	dd($arr);
});
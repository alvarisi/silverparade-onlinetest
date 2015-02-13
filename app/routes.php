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

Route::get('/', array('as'=>'home','uses' => 'HomeController@index'));
Route::post('/login', 'HomeController@login');
Route::get('/logout', 'HomeController@logout');

Route::group(array('before' => 'auth'), function()
{
	Route::get('/officer',array('as' => 'officer','uses' => 'OfficerController@index'));
	Route::get('/competition',array('as' => 'competition', 'uses' => 'CompetitionController@index'));
	Route::get('/competition/add','CompetitionController@create');
	Route::post('/competition/add','CompetitionController@store');
	Route::get('/competition/edit/{id?}','CompetitionController@edit');
	Route::post('/competition/edit/{id?}','CompetitionController@update');
	Route::get('/competition/destroy/{id?}','CompetitionController@destroy');

	Route::get('/competition/category','CategoryController@index');
	Route::get('/competition/category/edit/{id?}','CategoryController@edit');
	Route::post('/competition/category/edit/{id?}','CategoryController@update');
	Route::get('/competition/category/add','CategoryController@create');
	Route::post('/competition/category/add','CategoryController@store');
	Route::get('competition/category/destroy/{id?}','CategoryController@destroy');

	Route::get('/competition/question','QuestionController@index');
	Route::get('/competition/question/add','QuestionController@create');
	Route::post('/competition/question/add','QuestionController@store');
	Route::get('/competition/question/edit/{id?}','QuestionController@edit');
	Route::post('/competition/question/edit/{id?}','QuestionController@update');
	Route::get('/competition/question/info/{id?}','QuestionController@info');
	Route::get('/competition/question/destroy/{id?}','QuestionController@destroy');


	Route::get('/user/list','UserController@listUser');
	Route::get('/user/add','UserController@create');
	Route::post('/user/add','UserController@store');
	Route::get('/user/edit/{id?}','UserController@edit');
	Route::post('/user/edit/{id?}','UserController@update');
	Route::get('/user/reset/{id?}','UserController@reset');
	


	Route::get('/session','SesiController@index');
	Route::get('/session/add','SesiController@create');
	Route::post('/session/add','SesiController@store');
	Route::get('/session/edit/{id?}','SesiController@edit');
	Route::post('/session/edit/{id?}','SesiController@update');
	Route::get('/session/destroy/{id?}','SesiController@destroy');

	Route::get('/test/participant','TestController@participant');
	Route::post('/test/participant','TestController@participant');
	Route::post('/test/participant/add','TestController@store');
	Route::get('api/getSession','TestController@getSession');
	Route::get('test/participant/destroy/{id?}','TestController@destroy');

	Route::get('/test/result','TestController@result');
	Route::post('/test/result','TestController@result');
	Route::get('/officer/account','UserController@account');
	Route::get('/officer/account/edit','UserController@selfedit');
	Route::post('/officer/account/edit','UserController@selfedit');
	Route::get('/officer/account/changepassword','UserController@change');
	Route::post('/officer/account/changepassword','UserController@change');
});

Route::group(array('before' => 'auth.user'), function()
{
	Route::get('user/test/info/{id?}','TestController@goTest');
	Route::get('user/test/execute/{id?}','TestController@execute');
	Route::post('user/test/execute/{id?}','TestController@execute');

	Route::get('/user',array('as'=>'user', 'uses'=> 'UserController@index'));
	Route::get('/user/test/list', 'TestController@testlist');
	Route::get('/account','UserController@account');
	Route::get('/account/edit','UserController@selfedit');
	Route::post('/account/edit','UserController@selfedit');
	Route::get('/account/changepassword','UserController@change');
	Route::post('/account/changepassword','UserController@change');
});
Route::get('/cek',function(){
	$numbers = range(1, 10);
    shuffle($numbers);
    $arr = array_slice($numbers, 0, 10);
	echo "<pre>";
	dd($arr);
});
Route::get('/fak',function(){
	return View::make('page.officer.cek');
});
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::get('/dashboard', array('as' => 'dashboard', 'uses' => 'HomeController@dashboard'));
Route::get('/contacts', array('as' => 'contacts', 'uses' => 'ContactsController@contactList'));

Route::get('/phpinfo', function(){
	phpinfo();
	die();
});
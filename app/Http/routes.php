<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
	
	Route::get('/', 'ProductController@index');

    /* User Authentication */
	Route::get('auth/login', 'Auth\AuthController@getLogin');
	Route::post('auth/login', 'Auth\AuthController@postLogin');
	Route::get('auth/logout', 'Auth\AuthController@logout');
	
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');
	
	Route::get('/sources', 'SourceController@index');
	Route::post('/source', 'SourceController@source');
	Route::delete('/source/{source}', 'SourceController@destroy');
	
	Route::get('/locations', 'LocationController@index');
	Route::post('/location', 'LocationController@location');
	Route::delete('/location/{location}', 'LocationController@destroy');
	
	Route::get('/stores', 'StoreController@index');
	Route::post('/store', 'StoreController@store');
	Route::delete('/store/{store}', 'StoreController@destroy');
	
	Route::resource('product', 'ProductController');
	
	Route::resource('purchase', 'PurchaseController');
		
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FE\Home@index');
//login
Route::get('/login', 'Login@showLogin');
Route::post('/login', 'Login@login')->name('doLogin');
Route::get('/logout', 'Login@logout');
//register
Route::get('/register', 'Login@register');
Route::post('/doRegister', 'Login@doRegister')->name('doReg');
//go back
Route::get('/nothavepermission', function(){
	return view('welcome');
});
Route::get('/goback', function(){
	return redirect('/');
});
Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function(){
    //type
    Route::group(['prefix'=>'type'], function(){
    	Route::get('/', 'Admin\Type@getType');
    	Route::post('/editType','Admin\Type@doEdit');
    	Route::post('/sort', 'Admin\Type@sort');
    	Route::post('/detectID', 'Admin\Type@detectID');
    	Route::post('/confirmdelete', 'Admin\Type@confirmDelete')->name('type.confirm');
    });
});

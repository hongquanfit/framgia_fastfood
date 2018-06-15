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
//
Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function(){
    Route::get('/', function(){
        return view('welcome');
    });
});

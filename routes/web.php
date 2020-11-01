<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware'=>'auth'],function(){
    Route::get('/', 'HomeController@index')->name('user.home');
    
});

Route::group(['middleware'=>'re_user'],function(){

    Route::get('login','LoginController@login')->name('user.login');
    Route::post('login','LoginController@loginPost')->name('user.post-login');
    Route::get('reg','LoginController@reg')->name('user.reg');
    Route::post('reg','LoginController@regPost')->name('user.post-reg');
});

Route::get('/logout', 'LoginController@logout')->name('user.logout');

Auth::routes();



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'auth:admin'],function(){
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
});


Route::group(['middleware'=>'re_admin','namespace'=>'Admin'],function(){
    Route::get('login','AdminLoginController@login')->name('admin.login');
    Route::post('login','AdminLoginController@loginPost');
});

Route::get('/logout', 'AdminLoginController@logout')->name('admin.logout');
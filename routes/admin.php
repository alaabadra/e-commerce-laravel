<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'auth:admin'],function(){
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
});


Route::group(['middleware'=>'re_admin','namespace'=>'Admin'],function(){
    Route::get('login','LoginController@login')->name('admin.login');
    Route::post('login','LoginController@loginPost');
});

Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');
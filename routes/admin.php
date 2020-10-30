<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'guest:admin'],function(){
    Route::get('login','LoginController@getLogin')->name('admin.login');
});

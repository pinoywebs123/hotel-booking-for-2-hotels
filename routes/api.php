<?php

use Illuminate\Http\Request;


Route::group(['prefix'=> 'v1'], function(){

		Route::resource('rooms', 'api\CategoryController');

		Route::resource('rooms/info', 'api\RoomController');

		Route::post('/user', 'api\UserController@login');

		Route::get('/amenities', 'api\UserController@amenities');

		Route::post('/book', 'api\UserController@book');

		Route::post('/changepassword', 'api\UserController@change_password');

		Route::post('/signme', 'api\UserController@signme');

		Route::resource('/activity', 'api\ActivityController');

		Route::resource('/setting', 'api\SettingController');

		Route::resource('/payment', 'api\PaymentController');
});


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

Route::resource('photos', 'PhotoController', ['except' => 'create']);

Route::resource('albums', 'AlbumController');

Route::resource('rooms', 'RoomController');

Route::resource('features', 'FeatureController', ['except'=>['create', 'show']]);

Route::get('booking/create', 'BookingController@create')->name('bookings.create');
Route::get('booking', 'BookingController@index')->name('bookings.index');
Route::post('booking', 'BookingController@filter')->name('bookings.filter');;

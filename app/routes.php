<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array(
    'as' => 'index',
    'uses' => 'HomeController@getIndex')
);

Route::post('reservation', array(
    'as' => 'searchReservation',
    'uses' => 'ReservationController@index')
);

Route::post('reservation', array(
    'as' => 'searchReservation',
    'uses' => 'ReservationController@index')
);

Route::get('booking/{objParam}', array(
    'as' => 'createBooking',
    'uses' => 'BookingController@create')
);

Route::post('booking/{objParam}', array(
    'as' => 'newBooking',
    'uses' => 'BookingController@store')
);

Route::get('roomreservation', array(
    'as' => 'listRoomRates',
    'uses' => 'RoomRatesController@index')
);

Route::get('booking-success}', array(
    'as' => 'showBookingResult',
    'uses' => 'BookingController@show')
);


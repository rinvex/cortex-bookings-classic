<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Bookings\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Rooms Routes
             Route::name('rooms.')->prefix('rooms')->group(function () {
                 Route::get('/')->name('index')->uses('RoomsController@index');
                 Route::get('import')->name('import')->uses('RoomsController@import');
                 Route::post('import')->name('hoard')->uses('RoomsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('RoomsController@importLogs');
                 Route::get('create')->name('create')->uses('RoomsController@create');
                 Route::post('create')->name('store')->uses('RoomsController@store');
                 Route::get('{room}')->name('edit')->uses('RoomsController@edit');
                 Route::put('{room}')->name('update')->uses('RoomsController@update');
                 Route::get('{room}/logs')->name('logs')->uses('RoomsController@logs');
                 Route::delete('{room}')->name('destroy')->uses('RoomsController@destroy');

                 Route::name('media.')->prefix('{room}/media')->group(function () {
                     Route::get('/')->name('index')->uses('RoomMediaController@index');
                     Route::post('/')->name('store')->uses('RoomMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('RoomMediaController@destroy');
                 });

                 // Bookings Routes
                 Route::get('bookings')->name('bookings')->uses('RoomBookingsController@list');
                 Route::name('bookings.')->prefix('{room}/bookings')->group(function () {
                     Route::get('/')->name('index')->uses('RoomBookingsController@index');
                     Route::post('list')->name('list')->uses('RoomBookingsController@list');
                     Route::post('rooms')->name('rooms')->uses('RoomBookingsController@rooms');
                     Route::post('store')->name('store')->uses('RoomBookingsController@store');
                     Route::put('{booking}')->name('update')->uses('RoomBookingsController@update');
                     Route::delete('{booking}')->name('destroy')->uses('RoomBookingsController@destroy');
                 });
             });

             // Events Routes
             Route::name('events.')->prefix('events')->group(function () {
                 Route::get('/')->name('index')->uses('EventsController@index');
                 Route::get('import')->name('import')->uses('EventsController@import');
                 Route::post('import')->name('hoard')->uses('EventsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('EventsController@importLogs');
                 Route::get('create')->name('create')->uses('EventsController@create');
                 Route::post('create')->name('store')->uses('EventsController@store');
                 Route::get('{event}')->name('edit')->uses('EventsController@edit');
                 Route::put('{event}')->name('update')->uses('EventsController@update');
                 Route::get('{event}/logs')->name('logs')->uses('EventsController@logs');
                 Route::delete('{event}')->name('destroy')->uses('EventsController@destroy');

                 Route::name('media.')->prefix('{event}/media')->group(function () {
                     Route::get('/')->name('index')->uses('EventMediaController@index');
                     Route::post('/')->name('store')->uses('EventMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('EventMediaController@destroy');
                 });

                 Route::name('bookings.')->prefix('{event}/bookings')->group(function () {
                     Route::get('/')->name('index')->uses('EventMediaController@index');
                     Route::post('/')->name('store')->uses('EventMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('EventMediaController@destroy');
                 });

                 // Bookings Routes
                 Route::get('bookings')->name('bookings')->uses('EventBookingsController@all');
                 Route::name('bookings.')->prefix('{event}/bookings')->group(function () {
                     Route::get('/')->name('index')->uses('EventBookingsController@index');
                     Route::post('list')->name('list')->uses('EventBookingsController@list');
                     Route::post('customers')->name('customers')->uses('EventBookingsController@customers');
                     Route::post('rooms')->name('rooms')->uses('EventBookingsController@rooms');
                     Route::post('store')->name('store')->uses('EventBookingsController@store');
                     Route::put('{booking}')->name('update')->uses('EventBookingsController@update');
                     Route::delete('{booking}')->name('destroy')->uses('EventBookingsController@destroy');
                 });
             });
         });
});

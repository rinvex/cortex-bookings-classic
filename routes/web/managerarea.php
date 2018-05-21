<?php

declare(strict_types=1);

Route::domain('{subdomain}.'.domain())->group(function () {
    Route::name('managerarea.')
         ->namespace('Cortex\Bookings\Http\Controllers\Managerarea')
         ->middleware(['web', 'nohttpcache', 'can:access-managerarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.managerarea') : config('cortex.foundation.route.prefix.managerarea'))->group(function () {

            // Rooms Routes
             Route::name('rooms.')->prefix('rooms')->group(function () {
                 Route::get('/')->name('index')->uses('RoomsController@index');
                 Route::get('import')->name('import')->uses('RoomsController@import');
                 Route::post('import')->name('stash')->uses('RoomsController@stash');
                 Route::post('hoard')->name('hoard')->uses('RoomsController@hoard');
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
             });

             // Events Routes
             Route::name('events.')->prefix('events')->group(function () {
                 Route::get('/')->name('index')->uses('EventsController@index');
                 Route::get('import')->name('import')->uses('EventsController@import');
                 Route::post('import')->name('stash')->uses('EventsController@stash');
                 Route::post('hoard')->name('hoard')->uses('EventsController@hoard');
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
             });
         });
});

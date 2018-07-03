<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Bookings\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Services Routes
             Route::name('services.')->prefix('services')->group(function () {
                 Route::get('/')->name('index')->uses('ServicesController@index');
                 Route::get('import')->name('import')->uses('ServicesController@import');
                 Route::post('import')->name('stash')->uses('ServicesController@stash');
                 Route::post('hoard')->name('hoard')->uses('ServicesController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('ServicesController@importLogs');
                 Route::get('create')->name('create')->uses('ServicesController@create');
                 Route::post('create')->name('store')->uses('ServicesController@store');
                 Route::get('{service}')->name('edit')->uses('ServicesController@edit');
                 Route::put('{service}')->name('update')->uses('ServicesController@update');
                 Route::get('{service}/logs')->name('logs')->uses('ServicesController@logs');
                 Route::delete('{service}')->name('destroy')->uses('ServicesController@destroy');

                 Route::name('media.')->prefix('{service}/media')->group(function () {
                     Route::get('/')->name('index')->uses('ServiceMediaController@index');
                     Route::post('/')->name('store')->uses('ServiceMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('ServiceMediaController@destroy');
                 });

                 // Bookings Routes
                 Route::get('bookings')->name('bookings')->uses('ServiceBookingsController@list');
                 Route::name('bookings.')->prefix('{service}/bookings')->group(function () {
                     Route::get('/')->name('index')->uses('ServiceBookingsController@index');
                     Route::post('list')->name('list')->uses('ServiceBookingsController@list');
                     Route::post('services')->name('services')->uses('ServiceBookingsController@services');
                     Route::post('store')->name('store')->uses('ServiceBookingsController@store');
                     Route::put('{service_booking}')->name('update')->uses('ServiceBookingsController@update');
                     Route::delete('{service_booking}')->name('destroy')->uses('ServiceBookingsController@destroy');
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

                 // Tickets Routes
                 Route::name('tickets.')->prefix('{event}/tickets')->group(function () {
                     Route::get('/')->name('index')->uses('EventTicketsController@index');
                     Route::get('create')->name('create')->uses('EventTicketsController@create');
                     Route::post('create')->name('store')->uses('EventTicketsController@store');
                     Route::get('{event_ticket}')->name('edit')->uses('EventTicketsController@edit');
                     Route::put('{event_ticket}')->name('update')->uses('EventTicketsController@update');
                     Route::delete('{event_ticket}')->name('destroy')->uses('EventTicketsController@destroy');
                 });

                 // Bookings Routes
                 Route::name('bookings.')->prefix('{event}/bookings')->group(function () {
                     Route::get('/')->name('index')->uses('EventBookingsController@index');
                     Route::get('import')->name('import')->uses('EventBookingsController@import');
                     Route::post('import')->name('stash')->uses('EventBookingsController@stash');
                     Route::post('hoard')->name('hoard')->uses('EventBookingsController@hoard');
                     Route::get('create')->name('create')->uses('EventBookingsController@create');
                     Route::post('create')->name('store')->uses('EventBookingsController@store');
                     Route::get('{event_booking}')->name('edit')->uses('EventBookingsController@edit');
                     Route::put('{event_booking}')->name('update')->uses('EventBookingsController@update');
                     Route::delete('{event_booking}')->name('destroy')->uses('EventBookingsController@destroy');
                 });
             });
         });
});

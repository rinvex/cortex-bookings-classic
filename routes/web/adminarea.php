<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\Bookings\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Services Routes
             Route::name('services.')->prefix('services')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses('ServicesController@index');
                 Route::get('import')->name('import')->uses('ServicesController@import');
                 Route::post('import')->name('stash')->uses('ServicesController@stash');
                 Route::post('hoard')->name('hoard')->uses('ServicesController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('ServicesController@importLogs');
                 Route::get('create')->name('create')->uses('ServicesController@form');
                 Route::post('create')->name('store')->uses('ServicesController@store');
                 Route::get('{service}')->name('show')->uses('ServicesController@show');
                 Route::get('{service}/edit')->name('edit')->uses('ServicesController@form');
                 Route::put('{service}/edit')->name('update')->uses('ServicesController@update');
                 Route::get('{service}/logs')->name('logs')->uses('ServicesController@logs');
                 Route::delete('{service}')->name('destroy')->uses('ServicesController@destroy');

                 Route::name('media.')->prefix('{service}/media')->group(function () {
                     Route::get('/')->name('index')->uses('ServiceMediaController@index');
                     Route::post('/')->name('store')->uses('ServiceMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('ServiceMediaController@destroy');
                 });

                 // Bookings Routes
                 Route::name('bookings.')->prefix('{service}/bookings')->group(function () {
                     Route::match(['get', 'post'], '/')->name('index')->uses('ServiceBookingsController@index');
                     Route::get('import')->name('import')->uses('ServiceBookingsController@import');
                     Route::post('import')->name('stash')->uses('ServiceBookingsController@stash');
                     Route::post('hoard')->name('hoard')->uses('ServiceBookingsController@hoard');
                     Route::get('import/logs')->name('import.logs')->uses('ServiceBookingsController@importLogs');
                     Route::get('create')->name('create')->uses('ServiceBookingsController@form');
                     Route::post('create')->name('store')->uses('ServiceBookingsController@store');
                     Route::get('{service_booking}')->name('edit')->uses('ServiceBookingsController@form');
                     Route::put('{service_booking}')->name('update')->uses('ServiceBookingsController@update');
                     Route::get('{service_booking}/logs')->name('logs')->uses('ServiceBookingsController@logs');
                     Route::delete('{service_booking}')->name('destroy')->uses('ServiceBookingsController@destroy');
                 });
             });

             // Events Routes
             Route::name('events.')->prefix('events')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses('EventsController@index');
                 Route::get('import')->name('import')->uses('EventsController@import');
                 Route::post('import')->name('stash')->uses('EventsController@stash');
                 Route::post('hoard')->name('hoard')->uses('EventsController@hoard');
                 Route::get('import/logs')->name('import.logs')->uses('EventsController@importLogs');
                 Route::get('create')->name('create')->uses('EventsController@form');
                 Route::post('create')->name('store')->uses('EventsController@store');
                 Route::get('{event}')->name('show')->uses('EventsController@show');
                 Route::get('{event}/edit')->name('edit')->uses('EventsController@form');
                 Route::put('{event}/edit')->name('update')->uses('EventsController@update');
                 Route::get('{event}/logs')->name('logs')->uses('EventsController@logs');
                 Route::delete('{event}')->name('destroy')->uses('EventsController@destroy');

                 Route::name('media.')->prefix('{event}/media')->group(function () {
                     Route::get('/')->name('index')->uses('EventMediaController@index');
                     Route::post('/')->name('store')->uses('EventMediaController@store');
                     Route::delete('{media}')->name('destroy')->uses('EventMediaController@destroy');
                 });

                 // Tickets Routes
                 Route::name('tickets.')->prefix('{event}/tickets')->group(function () {
                     Route::match(['get', 'post'], '/')->name('index')->uses('EventTicketsController@index');
                     Route::get('create')->name('create')->uses('EventTicketsController@form');
                     Route::post('create')->name('store')->uses('EventTicketsController@store');
                     Route::get('{event_ticket}')->name('show')->uses('EventTicketsController@show');
                     Route::get('{event_ticket}/edit')->name('edit')->uses('EventTicketsController@form');
                     Route::put('{event_ticket}/edit')->name('update')->uses('EventTicketsController@update');
                     Route::delete('{event_ticket}')->name('destroy')->uses('EventTicketsController@destroy');
                 });

                 // Bookings Routes
                 Route::name('bookings.')->prefix('{event}/bookings')->group(function () {
                     Route::match(['get', 'post'], '/')->name('index')->uses('EventBookingsController@index');
                     Route::get('import')->name('import')->uses('EventBookingsController@import');
                     Route::post('import')->name('stash')->uses('EventBookingsController@stash');
                     Route::post('hoard')->name('hoard')->uses('EventBookingsController@hoard');
                     Route::get('create')->name('create')->uses('EventBookingsController@form');
                     Route::post('create')->name('store')->uses('EventBookingsController@store');
                     Route::get('{event_booking}')->name('show')->uses('EventBookingsController@show');
                     Route::get('{event_booking}/edit')->name('edit')->uses('EventBookingsController@form');
                     Route::put('{event_booking}/edit')->name('update')->uses('EventBookingsController@update');
                     Route::delete('{event_booking}')->name('destroy')->uses('EventBookingsController@destroy');
                 });
             });
         });
});

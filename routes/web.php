<?php

declare(strict_types=1);

Route::domain(domain())->group(function () {

    Route::name('adminarea.')
         ->namespace('Cortex\Bookings\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

        // Resources Routes
        Route::name('resources.')->prefix('resources')->group(function () {
            Route::get('/')->name('index')->uses('ResourcesController@index');
            Route::get('create')->name('create')->uses('ResourcesController@form');
            Route::post('create')->name('store')->uses('ResourcesController@store');
            Route::get('{resource}')->name('edit')->uses('ResourcesController@form');
            Route::put('{resource}')->name('update')->uses('ResourcesController@update');
            Route::get('{resource}/logs')->name('logs')->uses('ResourcesController@logs');
            Route::delete('{resource}')->name('delete')->uses('ResourcesController@delete');
        });

        // Bookings Routes
        Route::name('bookings.')->prefix('bookings')->group(function () {
            Route::get('/')->name('index')->uses('BookingsController@index');
            Route::post('list')->name('list')->uses('BookingsController@list');
            Route::post('customers')->name('customers')->uses('BookingsController@customers');
            Route::post('resources')->name('resources')->uses('BookingsController@resources');
            Route::post('store')->name('store')->uses('BookingsController@store');
            Route::put('{booking}')->name('update')->uses('BookingsController@update');
            Route::delete('{booking}')->name('delete')->uses('BookingsController@delete');
        });

    });

});


Route::domain('{subdomain}.'.domain())->group(function () {

    Route::name('tenantarea.')
         ->namespace('Cortex\Bookings\Http\Controllers\Tenantarea')
         ->middleware(['web', 'nohttpcache', 'can:access-tenantarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.tenantarea') : config('cortex.foundation.route.prefix.tenantarea'))->group(function () {

            // Resources Routes
            Route::name('resources.')->prefix('resources')->group(function () {
                Route::get('/')->name('index')->uses('ResourcesController@index');
                Route::get('create')->name('create')->uses('ResourcesController@form');
                Route::post('create')->name('store')->uses('ResourcesController@store');
                Route::get('{resource}')->name('edit')->uses('ResourcesController@form');
                Route::put('{resource}')->name('update')->uses('ResourcesController@update');
                Route::get('{resource}/logs')->name('logs')->uses('ResourcesController@logs');
                Route::delete('{resource}')->name('delete')->uses('ResourcesController@delete');
            });

            // Bookings Routes
            Route::name('bookings.')->prefix('bookings')->group(function () {
                Route::get('/')->name('index')->uses('BookingsController@index');
                Route::get('create')->name('create')->uses('BookingsController@form');
                Route::post('create')->name('store')->uses('BookingsController@store');
                Route::get('{resource}')->name('edit')->uses('BookingsController@form');
                Route::put('{resource}')->name('update')->uses('BookingsController@update');
                Route::get('{resource}/logs')->name('logs')->uses('BookingsController@logs');
                Route::delete('{resource}')->name('delete')->uses('BookingsController@delete');
            });

        });
});

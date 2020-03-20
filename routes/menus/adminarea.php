<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Event;
use Rinvex\Menus\Models\MenuItem;
use Cortex\Bookings\Models\Service;
use Rinvex\Menus\Models\MenuGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Service $service, Event $event) {
    $menu->dropdown(function (MenuItem $dropdown) use ($service, $event) {
        $dropdown->route(['adminarea.services.index'], trans('cortex/bookings::common.services'), null, 'fa fa-cubes')->ifCan('list', $service)->activateOnRoute('adminarea.services');
        $dropdown->route(['adminarea.events.index'], trans('cortex/bookings::common.events'), null, 'fa fa-cubes')->ifCan('list', $event)->activateOnRoute('adminarea.events');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

Menu::register('adminarea.services.tabs', function (MenuGenerator $menu, Service $service, Media $media) {
    $menu->route(['adminarea.services.import'], trans('cortex/bookings::common.records'))->ifCan('import', $service)->if(Route::is('adminarea.services.import*'));
    $menu->route(['adminarea.services.import.logs'], trans('cortex/bookings::common.logs'))->ifCan('import', $service)->if(Route::is('adminarea.services.import*'));
    $menu->route(['adminarea.services.create'], trans('cortex/bookings::common.details'))->ifCan('create', $service)->if(Route::is('adminarea.services.create'));
    $menu->route(['adminarea.services.edit', ['service' => $service]], trans('cortex/bookings::common.details'))->ifCan('update', $service)->if($service->exists);
    $menu->route(['adminarea.services.bookings.index', ['service' => $service]], trans('cortex/bookings::common.bookings'))->ifCan('book', $service)->if($service->exists);
    $menu->route(['adminarea.services.logs', ['service' => $service]], trans('cortex/bookings::common.logs'))->ifCan('audit', $service)->if($service->exists);
    $menu->route(['adminarea.services.media.index', ['service' => $service]], trans('cortex/bookings::common.media'))->ifCan('update', $service)->ifCan('list', $media)->if($service->exists);
});

Menu::register('adminarea.events.tabs', function (MenuGenerator $menu, Event $event, Media $media) {
    $menu->route(['adminarea.events.import'], trans('cortex/bookings::common.records'))->ifCan('import', $event)->if(Route::is('adminarea.events.import*'));
    $menu->route(['adminarea.events.import.logs'], trans('cortex/bookings::common.logs'))->ifCan('import', $event)->if(Route::is('adminarea.events.import*'));
    $menu->route(['adminarea.events.create'], trans('cortex/bookings::common.details'))->ifCan('create', $event)->if(Route::is('adminarea.events.create'));
    $menu->route(['adminarea.events.edit', ['event' => $event]], trans('cortex/bookings::common.details'))->ifCan('update', $event)->if($event->exists);
    $menu->route(['adminarea.events.tickets.index', ['event' => $event]], trans('cortex/bookings::common.tickets'))->ifCan('ticket', $event)->if($event->exists)->activateOnRoute('adminarea.events.tickets');
    $menu->route(['adminarea.events.bookings.index', ['event' => $event]], trans('cortex/bookings::common.bookings'))->ifCan('book', $event)->if($event->exists)->activateOnRoute('adminarea.events.bookings');
    $menu->route(['adminarea.events.logs', ['event' => $event]], trans('cortex/bookings::common.logs'))->ifCan('audit', $event)->if($event->exists);
    $menu->route(['adminarea.events.media.index', ['event' => $event]], trans('cortex/bookings::common.media'))->ifCan('update', $event)->ifCan('list', $media)->if($event->exists);
});

<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Room;
use Cortex\Bookings\Models\Event;
use Rinvex\Menus\Models\MenuItem;
use Cortex\Bookings\Models\Booking;
use Spatie\MediaLibrary\Models\Media;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('managerarea.sidebar', function (MenuGenerator $menu, Room $room, Event $event, Booking $booking) {
    $menu->dropdown(function (MenuItem $dropdown) use ($room, $event, $booking) {
        $dropdown->route(['managerarea.rooms.index'], trans('cortex/bookings::common.rooms'), null, 'fa fa-cubes')->ifCan('list', $room)->activateOnRoute('managerarea.rooms');
        $dropdown->route(['managerarea.events.index'], trans('cortex/bookings::common.events'), null, 'fa fa-cubes')->ifCan('list', $event)->activateOnRoute('managerarea.events');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

Menu::register('managerarea.rooms.tabs', function (MenuGenerator $menu, Room $room, Media $media) {
    $menu->route(['managerarea.rooms.import'], trans('cortex/bookings::common.file'))->ifCan('import', $room)->if(Route::is('managerarea.rooms.import*'));
    $menu->route(['managerarea.rooms.import.logs'], trans('cortex/bookings::common.logs'))->ifCan('import', $room)->if(Route::is('managerarea.rooms.import*'));
    $menu->route(['managerarea.rooms.create'], trans('cortex/bookings::common.details'))->ifCan('create', $room)->if(Route::is('managerarea.rooms.create'));
    $menu->route(['managerarea.rooms.edit', ['room' => $room]], trans('cortex/bookings::common.details'))->ifCan('update', $room)->if($room->exists);
    $menu->route(['managerarea.rooms.bookings.index', ['room' => $room]], trans('cortex/bookings::common.bookings'))->ifCan('book', $room)->if($room->exists);
    $menu->route(['managerarea.rooms.logs', ['room' => $room]], trans('cortex/bookings::common.logs'))->ifCan('audit', $room)->if($room->exists);
    $menu->route(['managerarea.rooms.media.index', ['room' => $room]], trans('cortex/bookings::common.media'))->ifCan('update', $room)->ifCan('list', $media)->if($room->exists);
});

Menu::register('managerarea.events.tabs', function (MenuGenerator $menu, Event $event, Media $media) {
    $menu->route(['managerarea.events.import'], trans('cortex/bookings::common.file'))->ifCan('import', $event)->if(Route::is('managerarea.events.import*'));
    $menu->route(['managerarea.events.import.logs'], trans('cortex/bookings::common.logs'))->ifCan('import', $event)->if(Route::is('managerarea.events.import*'));
    $menu->route(['managerarea.events.create'], trans('cortex/bookings::common.details'))->ifCan('create', $event)->if(Route::is('managerarea.events.create'));
    $menu->route(['managerarea.events.edit', ['event' => $event]], trans('cortex/bookings::common.details'))->ifCan('update', $event)->if($event->exists);
    $menu->route(['managerarea.events.bookings.index', ['event' => $event]], trans('cortex/bookings::common.bookings'))->ifCan('book', $event)->if($event->exists);
    $menu->route(['managerarea.events.logs', ['event' => $event]], trans('cortex/bookings::common.logs'))->ifCan('audit', $event)->if($event->exists);
    $menu->route(['managerarea.events.media.index', ['event' => $event]], trans('cortex/bookings::common.media'))->ifCan('update', $event)->ifCan('list', $media)->if($event->exists);
});

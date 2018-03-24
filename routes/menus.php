<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Room;
use Rinvex\Menus\Models\MenuItem;
use Cortex\Bookings\Models\Booking;
use Spatie\MediaLibrary\Models\Media;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Room $room, Booking $booking) {
    $menu->dropdown(function (MenuItem $dropdown) use ($room, $booking) {
        $dropdown->route(['adminarea.rooms.index'], trans('cortex/bookings::common.rooms'), 10, 'fa fa-cubes')->ifCan('list', $room)->activateOnRoute('adminarea.rooms');
        $dropdown->route(['adminarea.bookings.index'], trans('cortex/bookings::common.bookings'), 20, 'fa fa-calendar')->ifCan('list', $booking)->activateOnRoute('adminarea.bookings');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

Menu::register('managerarea.sidebar', function (MenuGenerator $menu, Room $room, Booking $booking) {
    $menu->dropdown(function (MenuItem $dropdown) use ($room, $booking) {
        $dropdown->route(['managerarea.rooms.index'], trans('cortex/bookings::common.rooms'), 10, 'fa fa-cubes')->ifCan('list', $room)->activateOnRoute('managerarea.rooms');
        $dropdown->route(['managerarea.bookings.index'], trans('cortex/bookings::common.bookings'), 20, 'fa fa-calendar')->ifCan('list', $booking)->activateOnRoute('managerarea.bookings');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

Menu::register('adminarea.rooms.tabs', function (MenuGenerator $menu, Room $room, Media $media) {
    $menu->route(['adminarea.rooms.create'], trans('cortex/bookings::common.details'))->ifCan('create', $room)->if(Route::is('adminarea.rooms.create'));
    $menu->route(['adminarea.rooms.edit', ['room' => $room]], trans('cortex/bookings::common.details'))->ifCan('update', $room)->if($room->exists);
    $menu->route(['adminarea.rooms.logs', ['room' => $room]], trans('cortex/bookings::common.logs'))->ifCan('audit', $room)->if($room->exists);
    $menu->route(['adminarea.rooms.media.index', ['room' => $room]], trans('cortex/bookings::common.media'))->ifCan('update', $room)->ifCan('list', $media)->if($room->exists);
});

Menu::register('managerarea.rooms.tabs', function (MenuGenerator $menu, Room $room, Media $media) {
    $menu->route(['managerarea.rooms.create'], trans('cortex/bookings::common.details'))->ifCan('create', $room)->if(Route::is('managerarea.rooms.create'));
    $menu->route(['managerarea.rooms.edit', ['room' => $room]], trans('cortex/bookings::common.details'))->ifCan('update', $room)->if($room->exists);
    $menu->route(['managerarea.rooms.logs', ['room' => $room]], trans('cortex/bookings::common.logs'))->ifCan('audit', $room)->if($room->exists);
    $menu->route(['managerarea.rooms.media.index', ['room' => $room]], trans('cortex/bookings::common.media'))->ifCan('update', $room)->ifCan('list', $media)->if($room->exists);
});

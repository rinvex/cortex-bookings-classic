<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->dropdown(function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.rooms.index'], trans('cortex/bookings::common.rooms'), 10, 'fa fa-cubes')->ifCan('list-rooms')->activateOnRoute('adminarea.rooms');
        $dropdown->route(['adminarea.bookings.index'], trans('cortex/bookings::common.bookings'), 20, 'fa fa-calendar')->ifCan('list-bookings')->activateOnRoute('adminarea.bookings');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

Menu::register('managerarea.sidebar', function (MenuGenerator $menu) {
    $menu->dropdown(function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.rooms.index'], trans('cortex/bookings::common.rooms'), 10, 'fa fa-cubes')->ifCan('list-rooms')->activateOnRoute('managerarea.rooms');
        $dropdown->route(['managerarea.bookings.index'], trans('cortex/bookings::common.bookings'), 20, 'fa fa-calendar')->ifCan('list-bookings')->activateOnRoute('managerarea.bookings');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

<?php

declare(strict_types=1);

use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Factories\MenuFactory;

Menu::modify('adminarea.sidebar', function (MenuFactory $menu) {
    $menu->dropdown(function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.rooms.index'], trans('cortex/bookings::common.rooms'), 10, 'fa fa-cubes')->can('list-rooms');
        $dropdown->route(['adminarea.bookings.index'], trans('cortex/bookings::common.bookings'), 20, 'fa fa-calendar')->can('list-bookings');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

Menu::modify('managerarea.sidebar', function (MenuFactory $menu) {
    $menu->dropdown(function (MenuItem $dropdown) {
        $dropdown->route(['managerarea.rooms.index'], trans('cortex/bookings::common.rooms'), 10, 'fa fa-cubes')->can('list-rooms');
        $dropdown->route(['managerarea.bookings.index'], trans('cortex/bookings::common.bookings'), 20, 'fa fa-calendar')->can('list-bookings');
    }, trans('cortex/bookings::common.space'), 60, 'fa fa-code-fork');
});

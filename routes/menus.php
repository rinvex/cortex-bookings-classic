<?php

declare(strict_types=1);

Menu::adminareaSidebar('resources')->routeIfCan('list-rooms', 'adminarea.rooms.index', '<i class="fa fa-cubes"></i> <span>'.trans('cortex/bookings::common.rooms').'</span>');
Menu::adminareaSidebar('resources')->routeIfCan('list-bookings', 'adminarea.bookings.index', '<i class="fa fa-calendar"></i> <span>'.trans('cortex/bookings::common.bookings').'</span>');
Menu::managerareaSidebar('resources')->routeIfCan('list-rooms', 'managerarea.rooms.index', '<i class="fa fa-cubes"></i> <span>'.trans('cortex/bookings::common.rooms').'</span>');
Menu::managerareaSidebar('resources')->routeIfCan('list-bookings', 'managerarea.bookings.index', '<i class="fa fa-calendar"></i> <span>'.trans('cortex/bookings::common.bookings').'</span>');

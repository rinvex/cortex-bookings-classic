<?php

declare(strict_types=1);

Menu::adminareaSidebar('resources')->routeIfCan('list-rooms', 'adminarea.rooms.index', '<i class="fa fa-cubes"></i> <span>'.trans('cortex/bookings::common.rooms').'</span>');
Menu::adminareaSidebar('resources')->routeIfCan('list-bookings', 'adminarea.bookings.index', '<i class="fa fa-calendar"></i> <span>'.trans('cortex/bookings::common.bookings').'</span>');
Menu::tenantareaSidebar('resources')->routeIfCan('list-rooms', 'tenantarea.rooms.index', '<i class="fa fa-cubes"></i> <span>'.trans('cortex/bookings::common.rooms').'</span>');
Menu::tenantareaSidebar('resources')->routeIfCan('list-bookings', 'tenantarea.bookings.index', '<i class="fa fa-calendar"></i> <span>'.trans('cortex/bookings::common.bookings').'</span>');

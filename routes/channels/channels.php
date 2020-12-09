<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('cortex.bookings.services.index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.service'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.bookings.services.bookings.index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.service.booking'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.bookings.events.index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.event'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.bookings.tickets.index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.ticket'));
}, ['guards' => ['admin']]);

Broadcast::channel('cortex.bookings.tickets.bookings.index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.ticket.booking'));
}, ['guards' => ['admin']]);

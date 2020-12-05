<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Access\Authorizable;

Broadcast::channel('adminarea-services-index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.service'));
}, ['guards' => ['admin']]);

Broadcast::channel('adminarea-services-bookings-index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.service.booking'));
}, ['guards' => ['admin']]);

Broadcast::channel('adminarea-events-index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.event'));
}, ['guards' => ['admin']]);

Broadcast::channel('adminarea-tickets-index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.ticket'));
}, ['guards' => ['admin']]);

Broadcast::channel('adminarea-tickets-bookings-index', function (Authorizable $user) {
    return $user->can('list', app('cortex.bookings.ticket.booking'));
}, ['guards' => ['admin']]);

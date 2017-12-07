<?php

declare(strict_types=1);

use Cortex\Bookings\Contracts\RoomContract;
use Rinvex\Bookings\Contracts\BookingContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

// Adminarea breadcrumbs
Breadcrumbs::register('adminarea.rooms.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.rooms'), route('adminarea.rooms.index'));
});

Breadcrumbs::register('adminarea.rooms.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_room'), route('adminarea.rooms.create'));
});

Breadcrumbs::register('adminarea.rooms.edit', function (BreadcrumbsGenerator $breadcrumbs, RoomContract $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->name, route('adminarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('adminarea.rooms.logs', function (BreadcrumbsGenerator $breadcrumbs, RoomContract $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->name, route('adminarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.rooms.logs', ['room' => $room]));
});

Breadcrumbs::register('adminarea.bookings.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('adminarea.bookings.index'));
});

Breadcrumbs::register('adminarea.bookings.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.bookings.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_booking'), route('adminarea.bookings.create'));
});

Breadcrumbs::register('adminarea.bookings.edit', function (BreadcrumbsGenerator $breadcrumbs, BookingContract $booking) {
    $breadcrumbs->parent('adminarea.bookings.index');
    $breadcrumbs->push($booking->name, route('adminarea.bookings.edit', ['booking' => $booking]));
});

Breadcrumbs::register('adminarea.bookings.logs', function (BreadcrumbsGenerator $breadcrumbs, BookingContract $booking) {
    $breadcrumbs->parent('adminarea.bookings.index');
    $breadcrumbs->push($booking->name, route('adminarea.bookings.edit', ['booking' => $booking]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.bookings.logs', ['booking' => $booking]));
});

// Tenantarea breadcrumbs
Breadcrumbs::register('tenantarea.rooms.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.tenantarea'), route('tenantarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.rooms'), route('tenantarea.rooms.index'));
});

Breadcrumbs::register('tenantarea.rooms.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('tenantarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_room'), route('tenantarea.rooms.create'));
});

Breadcrumbs::register('tenantarea.rooms.edit', function (BreadcrumbsGenerator $breadcrumbs, RoomContract $room) {
    $breadcrumbs->parent('tenantarea.rooms.index');
    $breadcrumbs->push($room->name, route('tenantarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('tenantarea.rooms.logs', function (BreadcrumbsGenerator $breadcrumbs, RoomContract $room) {
    $breadcrumbs->parent('tenantarea.rooms.index');
    $breadcrumbs->push($room->name, route('tenantarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('tenantarea.rooms.logs', ['room' => $room]));
});

Breadcrumbs::register('tenantarea.bookings.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.tenantarea'), route('tenantarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('tenantarea.bookings.index'));
});

Breadcrumbs::register('tenantarea.bookings.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('tenantarea.bookings.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_booking'), route('tenantarea.bookings.create'));
});

Breadcrumbs::register('tenantarea.bookings.edit', function (BreadcrumbsGenerator $breadcrumbs, BookingContract $booking) {
    $breadcrumbs->parent('tenantarea.bookings.index');
    $breadcrumbs->push($booking->name, route('tenantarea.bookings.edit', ['booking' => $booking]));
});

Breadcrumbs::register('tenantarea.bookings.logs', function (BreadcrumbsGenerator $breadcrumbs, BookingContract $booking) {
    $breadcrumbs->parent('tenantarea.bookings.index');
    $breadcrumbs->push($booking->name, route('tenantarea.bookings.edit', ['booking' => $booking]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('tenantarea.bookings.logs', ['booking' => $booking]));
});

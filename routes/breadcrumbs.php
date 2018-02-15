<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Room;
use Rinvex\Bookings\Models\Booking;
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

Breadcrumbs::register('adminarea.rooms.edit', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->name, route('adminarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('adminarea.rooms.logs', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->name, route('adminarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.rooms.logs', ['room' => $room]));
});

Breadcrumbs::register('adminarea.rooms.media.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->name, route('adminarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.media'), route('adminarea.rooms.media.index', ['room' => $room]));
});

Breadcrumbs::register('adminarea.bookings.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('adminarea.bookings.index'));
});

Breadcrumbs::register('adminarea.bookings.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.bookings.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_booking'), route('adminarea.bookings.create'));
});

Breadcrumbs::register('adminarea.bookings.edit', function (BreadcrumbsGenerator $breadcrumbs, Booking $booking) {
    $breadcrumbs->parent('adminarea.bookings.index');
    $breadcrumbs->push($booking->name, route('adminarea.bookings.edit', ['booking' => $booking]));
});

Breadcrumbs::register('adminarea.bookings.logs', function (BreadcrumbsGenerator $breadcrumbs, Booking $booking) {
    $breadcrumbs->parent('adminarea.bookings.index');
    $breadcrumbs->push($booking->name, route('adminarea.bookings.edit', ['booking' => $booking]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.bookings.logs', ['booking' => $booking]));
});

// Managerarea breadcrumbs
Breadcrumbs::register('managerarea.rooms.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.rooms'), route('managerarea.rooms.index'));
});

Breadcrumbs::register('managerarea.rooms.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_room'), route('managerarea.rooms.create'));
});

Breadcrumbs::register('managerarea.rooms.edit', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push($room->name, route('managerarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('managerarea.rooms.logs', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push($room->name, route('managerarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.rooms.logs', ['room' => $room]));
});

Breadcrumbs::register('managerarea.bookings.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('managerarea.bookings.index'));
});

Breadcrumbs::register('managerarea.bookings.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.bookings.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_booking'), route('managerarea.bookings.create'));
});

Breadcrumbs::register('managerarea.bookings.edit', function (BreadcrumbsGenerator $breadcrumbs, Booking $booking) {
    $breadcrumbs->parent('managerarea.bookings.index');
    $breadcrumbs->push($booking->name, route('managerarea.bookings.edit', ['booking' => $booking]));
});

Breadcrumbs::register('managerarea.bookings.logs', function (BreadcrumbsGenerator $breadcrumbs, Booking $booking) {
    $breadcrumbs->parent('managerarea.bookings.index');
    $breadcrumbs->push($booking->name, route('managerarea.bookings.edit', ['booking' => $booking]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.bookings.logs', ['booking' => $booking]));
});

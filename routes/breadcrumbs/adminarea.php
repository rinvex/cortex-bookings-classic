<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Room;
use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\EventTicket;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.rooms.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.rooms'), route('adminarea.rooms.index'));
});

Breadcrumbs::register('adminarea.rooms.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('adminarea.rooms.import'));
});

Breadcrumbs::register('adminarea.rooms.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('adminarea.rooms.import'));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.rooms.import.logs'));
});

Breadcrumbs::register('adminarea.rooms.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_room'), route('adminarea.rooms.create'));
});

Breadcrumbs::register('adminarea.rooms.edit', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->name, route('adminarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('adminarea.rooms.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->name, route('adminarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('adminarea.rooms.bookings.index', ['room' => $room]));
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

Breadcrumbs::register('adminarea.events.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.events'), route('adminarea.events.index'));
});

Breadcrumbs::register('adminarea.events.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('adminarea.events.import'));
});

Breadcrumbs::register('adminarea.events.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('adminarea.events.import'));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.events.import.logs'));
});

Breadcrumbs::register('adminarea.events.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_event'), route('adminarea.events.create'));
});

Breadcrumbs::register('adminarea.events.edit', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push($event->name, route('adminarea.events.edit', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.logs', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push($event->name, route('adminarea.events.edit', ['event' => $event]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.events.logs', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.media.index', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push($event->name, route('adminarea.events.edit', ['event' => $event]));
    $breadcrumbs->push(trans('cortex/bookings::common.media'), route('adminarea.events.media.index', ['event' => $event]));
});










Breadcrumbs::register('adminarea.events.tickets.index', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.edit', $event);
    $breadcrumbs->push(trans('cortex/bookings::common.tickets'), route('adminarea.events.tickets.index', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.tickets.create', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.tickets.index', $event);
    $breadcrumbs->push(trans('cortex/bookings::common.create_ticket'), route('adminarea.events.tickets.create', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.tickets.edit', function (BreadcrumbsGenerator $breadcrumbs, Event $event, EventTicket $eventTicket) {
    $breadcrumbs->parent('adminarea.events.tickets.index', $event);
    $breadcrumbs->push($eventTicket->name, route('adminarea.events.tickets.edit', ['event' => $event, 'ticket' => $eventTicket]));
});




Breadcrumbs::register('adminarea.events.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.edit', $event);
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('adminarea.events.bookings.index', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.bookings.create', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.bookings.index', $event);
    $breadcrumbs->push(trans('cortex/bookings::common.create_booking'), route('adminarea.events.bookings.create', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.bookings.edit', function (BreadcrumbsGenerator $breadcrumbs, Event $event, EventBooking $eventBooking) {
    $breadcrumbs->parent('adminarea.events.bookings.index', $event);
    $breadcrumbs->push($eventBooking->name, route('adminarea.events.bookings.edit', ['event' => $event, 'booking' => $eventBooking]));
});

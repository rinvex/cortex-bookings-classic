<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Room;
use Cortex\Bookings\Models\Event;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

// Adminarea breadcrumbs
Breadcrumbs::register('adminarea.rooms.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
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
    $breadcrumbs->push($room->title, route('adminarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('adminarea.rooms.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->title, route('adminarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('adminarea.rooms.bookings.index', ['room' => $room]));
});

Breadcrumbs::register('adminarea.rooms.logs', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->title, route('adminarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.rooms.logs', ['room' => $room]));
});

Breadcrumbs::register('adminarea.rooms.media.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.rooms.index');
    $breadcrumbs->push($room->title, route('adminarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.media'), route('adminarea.rooms.media.index', ['room' => $room]));
});

Breadcrumbs::register('adminarea.events.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
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
    $breadcrumbs->push($event->title, route('adminarea.events.edit', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push($room->title, route('adminarea.events.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('adminarea.events.bookings.index', ['room' => $room]));
});

Breadcrumbs::register('adminarea.events.logs', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push($event->title, route('adminarea.events.edit', ['event' => $event]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.events.logs', ['event' => $event]));
});

Breadcrumbs::register('adminarea.events.media.index', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.index');
    $breadcrumbs->push($event->title, route('adminarea.events.edit', ['event' => $event]));
    $breadcrumbs->push(trans('cortex/bookings::common.media'), route('adminarea.events.media.index', ['event' => $event]));
});

// Managerarea breadcrumbs
Breadcrumbs::register('managerarea.rooms.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.rooms'), route('managerarea.rooms.index'));
});

Breadcrumbs::register('managerarea.rooms.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('managerarea.rooms.import'));
});

Breadcrumbs::register('managerarea.rooms.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('managerarea.rooms.import'));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.rooms.import.logs'));
});

Breadcrumbs::register('managerarea.rooms.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_room'), route('managerarea.rooms.create'));
});

Breadcrumbs::register('managerarea.rooms.edit', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push($room->title, route('managerarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('managerarea.rooms.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push($room->title, route('managerarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('managerarea.rooms.bookings.index', ['room' => $room]));
});

Breadcrumbs::register('managerarea.rooms.logs', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push($room->title, route('managerarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.rooms.logs', ['room' => $room]));
});

Breadcrumbs::register('managerarea.events.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.events'), route('managerarea.events.index'));
});

Breadcrumbs::register('managerarea.events.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('managerarea.events.import'));
});

Breadcrumbs::register('managerarea.events.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('managerarea.events.import'));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.events.import.logs'));
});

Breadcrumbs::register('managerarea.events.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_event'), route('managerarea.events.create'));
});

Breadcrumbs::register('managerarea.events.edit', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push($event->title, route('managerarea.events.edit', ['event' => $event]));
});

Breadcrumbs::register('managerarea.events.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push($room->title, route('managerarea.events.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('managerarea.events.bookings.index', ['room' => $room]));
});

Breadcrumbs::register('managerarea.events.logs', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push($event->title, route('managerarea.events.edit', ['event' => $event]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.events.logs', ['event' => $event]));
});

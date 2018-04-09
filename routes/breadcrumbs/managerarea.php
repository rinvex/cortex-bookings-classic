<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Room;
use Cortex\Bookings\Models\Event;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('managerarea.rooms.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('rinvex.tenants.active')->name, route('managerarea.home'));
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
    $breadcrumbs->push($room->name, route('managerarea.rooms.edit', ['room' => $room]));
});

Breadcrumbs::register('managerarea.rooms.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push($room->name, route('managerarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('managerarea.rooms.bookings.index', ['room' => $room]));
});

Breadcrumbs::register('managerarea.rooms.logs', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.rooms.index');
    $breadcrumbs->push($room->name, route('managerarea.rooms.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.rooms.logs', ['room' => $room]));
});

Breadcrumbs::register('managerarea.events.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('rinvex.tenants.active')->name, route('managerarea.home'));
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
    $breadcrumbs->push($event->name, route('managerarea.events.edit', ['event' => $event]));
});

Breadcrumbs::register('managerarea.events.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Room $room) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push($room->name, route('managerarea.events.edit', ['room' => $room]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('managerarea.events.bookings.index', ['room' => $room]));
});

Breadcrumbs::register('managerarea.events.logs', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('managerarea.events.index');
    $breadcrumbs->push($event->name, route('managerarea.events.edit', ['event' => $event]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('managerarea.events.logs', ['event' => $event]));
});

<?php

declare(strict_types=1);

use Cortex\Bookings\Models\Service;
use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\EventTicket;
use Cortex\Bookings\Models\EventBooking;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.services.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.services'), route('adminarea.services.index'));
});

Breadcrumbs::register('adminarea.services.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.services.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('adminarea.services.import'));
});

Breadcrumbs::register('adminarea.services.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.services.index');
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('adminarea.services.import'));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.services.import.logs'));
});

Breadcrumbs::register('adminarea.services.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.services.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_service'), route('adminarea.services.create'));
});

Breadcrumbs::register('adminarea.services.edit', function (BreadcrumbsGenerator $breadcrumbs, Service $service) {
    $breadcrumbs->parent('adminarea.services.index');
    $breadcrumbs->push($service->name, route('adminarea.services.edit', ['service' => $service]));
});

Breadcrumbs::register('adminarea.services.bookings.index', function (BreadcrumbsGenerator $breadcrumbs, Service $service) {
    $breadcrumbs->parent('adminarea.services.index');
    $breadcrumbs->push($service->name, route('adminarea.services.edit', ['service' => $service]));
    $breadcrumbs->push(trans('cortex/bookings::common.bookings'), route('adminarea.services.bookings.index', ['service' => $service]));
});

Breadcrumbs::register('adminarea.services.logs', function (BreadcrumbsGenerator $breadcrumbs, Service $service) {
    $breadcrumbs->parent('adminarea.services.index');
    $breadcrumbs->push($service->name, route('adminarea.services.edit', ['service' => $service]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.services.logs', ['service' => $service]));
});

Breadcrumbs::register('adminarea.services.media.index', function (BreadcrumbsGenerator $breadcrumbs, Service $service) {
    $breadcrumbs->parent('adminarea.services.index');
    $breadcrumbs->push($service->name, route('adminarea.services.edit', ['service' => $service]));
    $breadcrumbs->push(trans('cortex/bookings::common.media'), route('adminarea.services.media.index', ['service' => $service]));
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

Breadcrumbs::register('adminarea.events.bookings.import', function (BreadcrumbsGenerator $breadcrumbs, Event $event) {
    $breadcrumbs->parent('adminarea.events.bookings.index', $event);
    $breadcrumbs->push(trans('cortex/bookings::common.import'), route('adminarea.events.bookings.import', ['event' => $event]));
});

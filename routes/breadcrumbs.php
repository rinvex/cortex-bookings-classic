<?php

declare(strict_types=1);

use Rinvex\Bookings\Contracts\BookingContract;
use Cortex\Bookings\Contracts\ResourceContract;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

// Adminarea breadcrumbs
Breadcrumbs::register('adminarea.resources.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.resources'), route('adminarea.resources.index'));
});

Breadcrumbs::register('adminarea.resources.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.resources.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_resource'), route('adminarea.resources.create'));
});

Breadcrumbs::register('adminarea.resources.edit', function (BreadcrumbsGenerator $breadcrumbs, ResourceContract $resource) {
    $breadcrumbs->parent('adminarea.resources.index');
    $breadcrumbs->push($resource->name, route('adminarea.resources.edit', ['resource' => $resource]));
});

Breadcrumbs::register('adminarea.resources.logs', function (BreadcrumbsGenerator $breadcrumbs, ResourceContract $resource) {
    $breadcrumbs->parent('adminarea.resources.index');
    $breadcrumbs->push($resource->name, route('adminarea.resources.edit', ['resource' => $resource]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('adminarea.resources.logs', ['resource' => $resource]));
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
Breadcrumbs::register('tenantarea.resources.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.tenantarea'), route('tenantarea.home'));
    $breadcrumbs->push(trans('cortex/bookings::common.resources'), route('tenantarea.resources.index'));
});

Breadcrumbs::register('tenantarea.resources.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('tenantarea.resources.index');
    $breadcrumbs->push(trans('cortex/bookings::common.create_resource'), route('tenantarea.resources.create'));
});

Breadcrumbs::register('tenantarea.resources.edit', function (BreadcrumbsGenerator $breadcrumbs, ResourceContract $resource) {
    $breadcrumbs->parent('tenantarea.resources.index');
    $breadcrumbs->push($resource->name, route('tenantarea.resources.edit', ['resource' => $resource]));
});

Breadcrumbs::register('tenantarea.resources.logs', function (BreadcrumbsGenerator $breadcrumbs, ResourceContract $resource) {
    $breadcrumbs->parent('tenantarea.resources.index');
    $breadcrumbs->push($resource->name, route('tenantarea.resources.edit', ['resource' => $resource]));
    $breadcrumbs->push(trans('cortex/bookings::common.logs'), route('tenantarea.resources.logs', ['resource' => $resource]));
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

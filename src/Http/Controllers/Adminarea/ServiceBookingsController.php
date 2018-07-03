<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Service;
use Illuminate\Support\Facades\DB;
use Cortex\Bookings\Models\BookableBooking;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest;

class ServiceBookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = BookableBooking::class;

    /**
     * {@inheritdoc}
     */
    protected $resourceMethodsWithoutModels = [
        'customers',
        'services',
        'list',
    ];

    /**
     * {@inheritdoc}
     */
    public function authorizeResource($model, $parameter = null, array $options = [], $request = null): void
    {
        $middleware = [];
        $parameter = $parameter ?: snake_case(class_basename($model));

        foreach ($this->mapResourceAbilities() as $method => $ability) {
            $modelName = in_array($method, $this->resourceMethodsWithoutModels()) ? $model : $parameter;

            $middleware["can:update,{$modelName}"][] = $method;
            $middleware["can:{$ability},bookings"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * List all bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('cortex/bookings::adminarea.pages.bookings');
    }

    /**
     * List the bookings.
     *
     * @return array
     */
    public function list(Service $service): array
    {
        $results = [];
        $rangeEnds = request()->get('end');
        $rangeStarts = request()->get('start');
        $bookableBookings = app('cortex.bookings.service_booking')->range($rangeStarts, $rangeEnds)->get();

        foreach ($bookableBookings as $bookableBooking) {
            $endTime = $bookableBooking->ends_at->toTimeString();
            $startTime = $bookableBooking->starts_at->toTimeString();
            $endsAt = optional($bookableBooking->ends_at)->toDateTimeString();
            $startsAt = optional($bookableBooking->starts_at)->toDateTimeString();
            $allDay = ($startTime === '00:00:00' && $endTime === '00:00:00' ? true : false);

            $results[] = [
                'id' => $bookableBooking->getKey(),
                'customerId' => $bookableBooking->customer->getKey(),
                'serviceId' => $bookableBooking->bookable->getKey(),
                'className' => $bookableBooking->bookable->style,
                'title' => $bookableBooking->customer->full_name.' ('.$bookableBooking->bookable->name.')',
                'start' => $allDay ? $bookableBooking->starts_at->toDateString() : $startsAt,
                'end' => $allDay ? $bookableBooking->ends_at->toDateString() : $endsAt,
            ];
        }

        return $results;
    }

    /**
     * List the bookings.
     *
     * @return array
     */
    public function services(): array
    {
        $services = app('cortex.bookings.service')->all(['id', DB::raw('JSON_EXTRACT(title, "$.en") as title'), 'style']);

        return $services;
    }

    /**
     * Store new booking.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest $request
     *
     * @return int
     */
    public function store(BookingFormRequest $request): int
    {
        return $this->process($request, app('cortex.bookings.service_booking'));
    }

    /**
     * Update given booking.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest $request
     * @param \Cortex\Bookings\Models\BookableBooking                     $bookableBooking
     *
     * @return int
     */
    public function update(BookingFormRequest $request, BookableBooking $bookableBooking): int
    {
        return $this->process($request, $bookableBooking);
    }

    /**
     * Process stored/updated booking.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\BookableBooking $bookableBooking
     *
     * @return int
     */
    protected function process(FormRequest $request, BookableBooking $bookableBooking): int
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save booking
        $bookableBooking->fill($data)->save();

        return $bookableBooking->getKey();
    }

    /**
     * Destroy given booking.
     *
     * @param \Cortex\Bookings\Models\Service                    $service
     * @param \Cortex\Bookings\Models\BookableBookableBooking $bookableBooking
     *
     * @return int
     */
    public function destroy(Service $service, BookableBooking $bookableBooking): int
    {
        $service->bookings()->where($bookableBooking->getKeyName(), $bookableBooking->getKey())->first()->delete();

        return $bookableBooking->getKey();
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Illuminate\Support\Facades\DB;
use Cortex\Bookings\Models\Service;
use Cortex\Bookings\Models\ServiceBooking;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest;

class ServiceBookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = ServiceBooking::class;

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
        $serviceBookings = app('cortex.bookings.service_booking')->range($rangeStarts, $rangeEnds)->get();

        foreach ($serviceBookings as $serviceBooking) {
            $endTime = $serviceBooking->ends_at->toTimeString();
            $startTime = $serviceBooking->starts_at->toTimeString();
            $endsAt = optional($serviceBooking->ends_at)->toDateTimeString();
            $startsAt = optional($serviceBooking->starts_at)->toDateTimeString();
            $allDay = ($startTime === '00:00:00' && $endTime === '00:00:00' ? true : false);

            $results[] = [
                'id' => $serviceBooking->getKey(),
                'customerId' => $serviceBooking->customer->getKey(),
                'serviceId' => $serviceBooking->bookable->getKey(),
                'className' => $serviceBooking->bookable->style,
                'title' => $serviceBooking->customer->full_name.' ('.$serviceBooking->bookable->name.')',
                'start' => $allDay ? $serviceBooking->starts_at->toDateString() : $startsAt,
                'end' => $allDay ? $serviceBooking->ends_at->toDateString() : $endsAt,
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
     * @param \Cortex\Bookings\Models\ServiceBooking                      $serviceBooking
     *
     * @return int
     */
    public function update(BookingFormRequest $request, ServiceBooking $serviceBooking): int
    {
        return $this->process($request, $serviceBooking);
    }

    /**
     * Process stored/updated booking.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\ServiceBooking  $serviceBooking
     *
     * @return int
     */
    protected function process(FormRequest $request, ServiceBooking $serviceBooking): int
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save booking
        $serviceBooking->fill($data)->save();

        return $serviceBooking->getKey();
    }

    /**
     * Destroy given booking.
     *
     * @param \Cortex\Bookings\Models\Service        $service
     * @param \Cortex\Bookings\Models\ServiceBooking $serviceBooking
     *
     * @return int
     */
    public function destroy(Service $service, ServiceBooking $serviceBooking): int
    {
        $service->bookings()->where($serviceBooking->getKeyName(), $serviceBooking->getKey())->first()->delete();

        return $serviceBooking->getKey();
    }
}

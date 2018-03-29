<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Room;
use Illuminate\Support\Facades\DB;
use Cortex\Bookings\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest;

class RoomBookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Booking::class;

    /**
     * {@inheritdoc}
     */
    protected $resourceMethodsWithoutModels = [
        'customers',
        'rooms',
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
    public function list(Room $room): array
    {
        $results = [];
        $rangeEnds = request()->get('end');
        $rangeStarts = request()->get('start');
        $bookings = app('rinvex.bookings.booking')->range($rangeStarts, $rangeEnds)->get();

        foreach ($bookings as $booking) {
            $endTime = $booking->ends_at->toTimeString();
            $startTime = $booking->starts_at->toTimeString();
            $endsAt = optional($booking->ends_at)->toDateTimeString();
            $startsAt = optional($booking->starts_at)->toDateTimeString();
            $allDay = ($startTime === '00:00:00' && $endTime === '00:00:00' ? true : false);

            $results[] = [
                'id' => $booking->getKey(),
                'customerId' => $booking->customer->getKey(),
                'roomId' => $booking->bookable->getKey(),
                'className' => $booking->bookable->style,
                'title' => $booking->customer->name.' ('.$booking->bookable->title.')',
                'start' => $allDay ? $booking->starts_at->toDateString() : $startsAt,
                'end' => $allDay ? $booking->ends_at->toDateString() : $endsAt,
            ];
        }

        return $results;
    }

    /**
     * List the bookings.
     *
     * @return array
     */
    public function rooms(): array
    {
        $rooms = app('cortex.bookings.room')->all(['id', DB::raw('JSON_EXTRACT(title, "$.en") as title'), 'style']);

        return $rooms;
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
        return $this->process($request, app('rinvex.bookings.booking'));
    }

    /**
     * Update given booking.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest $request
     * @param \Cortex\Bookings\Models\Booking                             $booking
     *
     * @return int
     */
    public function update(BookingFormRequest $request, Booking $booking): int
    {
        return $this->process($request, $booking);
    }

    /**
     * Process stored/updated booking.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\Booking         $booking
     *
     * @return int
     */
    protected function process(FormRequest $request, Booking $booking): int
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save booking
        $booking->fill($data)->save();

        return $booking->getKey();
    }

    /**
     * Destroy given booking.
     *
     * @param \Cortex\Bookings\Models\Room    $room
     * @param \Cortex\Bookings\Models\Booking $booking
     *
     * @return int
     */
    public function destroy(Room $room, Booking $booking): int
    {
        $room->bookings()->where($booking->getKeyName(), $booking->getKey())->first()->delete();

        return $booking->getKey();
    }
}

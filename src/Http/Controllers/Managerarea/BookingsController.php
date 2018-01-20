<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Managerarea;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;
use Rinvex\Bookings\Contracts\BookingContract;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Managerarea\BookingFormRequest;

class BookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'bookings';

    /**
     * Display a listing of the booking.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('cortex/bookings::managerarea.pages.bookings');
    }

    /**
     * List the bookings.
     *
     * @return array
     */
    public function list(): array
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
                'title' => $booking->customer->name.' ('.$booking->bookable->name.')',
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
    public function customers(): array
    {
        $customers = app('rinvex.fort.user')->withAnyRoles(['member'])->get()->pluck('name', 'id');

        return $customers;
    }

    /**
     * List the bookings.
     *
     * @return array
     */
    public function rooms(): array
    {
        $rooms = app('cortex.bookings.room')->all(['id', DB::raw('JSON_EXTRACT(name, "$.en") as name'), 'style']);

        return $rooms;
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\BookingFormRequest $request
     *
     * @return int
     */
    public function store(BookingFormRequest $request): int
    {
        return $this->process($request, app('rinvex.bookings.booking'));
    }

    /**
     * Update the given booking in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\BookingFormRequest $request
     * @param \Rinvex\Bookings\Contracts\BookingContract                    $booking
     *
     * @return int
     */
    public function update(BookingFormRequest $request, BookingContract $booking): int
    {
        return $this->process($request, $booking);
    }

    /**
     * Process the form for store/update of the given booking.
     *
     * @param \Illuminate\Foundation\Http\FormRequest    $request
     * @param \Rinvex\Bookings\Contracts\BookingContract $booking
     *
     * @return int
     */
    protected function process(FormRequest $request, BookingContract $booking): int
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save booking
        $booking->fill($data)->save();

        return $booking->getKey();
    }

    /**
     * Delete the given booking from storage.
     *
     * @param \Rinvex\Bookings\Contracts\BookingContract $booking
     *
     * @return int
     */
    public function delete(BookingContract $booking): int
    {
        $booking->delete();

        return $booking->getKey();
    }
}

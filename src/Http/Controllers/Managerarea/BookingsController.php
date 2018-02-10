<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Managerarea;

use Illuminate\Support\Facades\DB;
use Rinvex\Bookings\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Managerarea\BookingFormRequest;

class BookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'booking';

    /**
     * {@inheritdoc}
     */
    protected $resourceMethodsWithoutModels = [
        'list',
        'users',
        'rooms',
    ];

    /**
     * List all bookings.
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
                'userId' => $booking->user->getKey(),
                'roomId' => $booking->bookable->getKey(),
                'className' => $booking->bookable->style,
                'title' => $booking->user->name.' ('.$booking->bookable->name.')',
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
    public function users(): array
    {
        $users = app('rinvex.fort.user')->withAnyRoles(['member'])->get()->pluck('name', 'id');

        return $users;
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
     * Store new booking.
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
     * Update given booking.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\BookingFormRequest $request
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
     * @param \Cortex\Bookings\Models\Booking $booking
     *
     * @return int
     */
    public function destroy(Booking $booking): int
    {
        $booking->delete();

        return $booking->getKey();
    }
}

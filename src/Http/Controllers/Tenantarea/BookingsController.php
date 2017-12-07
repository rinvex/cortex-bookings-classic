<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Tenantarea;

use Illuminate\Http\Request;
use Rinvex\Bookings\Contracts\BookingContract;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Tenantarea\BookingFormRequest;

class BookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'bookings';

    /**
     * Display a listing of the booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = app('cortex.bookings.room')->all()->pluck('name', 'id');
        $customers = app('rinvex.fort.user')->role('member')->get()->pluck('username', 'id');

        return view('cortex/bookings::tenantarea.pages.bookings', compact('rooms', 'customers'));
    }

    /**
     * Display a listing of the booking logs.
     *
     * @param \Rinvex\Bookings\Contracts\BookingContract  $booking
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function logs(BookingContract $booking, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'tab' => 'logs',
            'type' => 'bookings',
            'booking' => $booking,
            'id' => 'cortex-bookings-logs',
            'phrase' => trans('cortex/bookings::common.bookings'),
        ])->render('cortex/foundation::tenantarea.pages.datatable-tab');
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Tenantarea\BookingFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BookingFormRequest $request)
    {
        return $this->process($request, app('rinvex.bookings.booking'));
    }

    /**
     * Update the given booking in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Tenantarea\BookingFormRequest $request
     * @param \Rinvex\Bookings\Contracts\BookingContract                  $booking
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BookingFormRequest $request, BookingContract $booking)
    {
        return $this->process($request, $booking);
    }

    /**
     * Delete the given booking from storage.
     *
     * @param \Rinvex\Bookings\Contracts\BookingContract $booking
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(BookingContract $booking)
    {
        $booking->delete();

        return intend([
            'url' => route('tenantarea.bookings.index'),
            'with' => ['warning' => trans('cortex/bookings::messages.booking.deleted', ['slug' => $booking->slug])],
        ]);
    }

    /**
     * Show the form for create/update of the given booking.
     *
     * @param \Rinvex\Bookings\Contracts\BookingContract $booking
     *
     * @return \Illuminate\Http\Response
     */
    public function form(BookingContract $booking)
    {
        return view('cortex/bookings::tenantarea.forms.booking', compact('booking'));
    }

    /**
     * Process the form for store/update of the given booking.
     *
     * @param \Illuminate\Http\Request                   $request
     * @param \Rinvex\Bookings\Contracts\BookingContract $booking
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, BookingContract $booking)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save booking
        $booking->fill($data)->save();

        return intend([
            'url' => route('tenantarea.bookings.index'),
            'with' => ['success' => trans('cortex/bookings::messages.booking.saved', ['slug' => $booking->slug])],
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\EventBooking;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\DataTables\Adminarea\EventBookingsDataTable;
use Cortex\Bookings\Http\Requests\Adminarea\EventBookingFormRequest;

class EventBookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = EventBooking::class;

    /**
     * List all event bookings.
     *
     * @param \Cortex\Bookings\Models\Event                         $event
     * @param \Cortex\Bookings\DataTables\Adminarea\EventsDataTable $eventsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Event $event, EventBookingsDataTable $eventsDataTable)
    {
        return $eventsDataTable->with([
            'resource' => $event,
            'tabs' => 'adminarea.events.tabs',
            'id' => "adminarea-events-{$event->getRouteKey()}-bookings-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Create new event.
     *
     * @param \Cortex\Bookings\Models\Event        $event
     * @param \Cortex\Bookings\Models\EventBooking $eventBooking
     *
     * @return \Illuminate\View\View
     */
    public function create(Event $event, EventBooking $eventBooking)
    {
        return $this->form($event, $eventBooking);
    }

    /**
     * Edit given event.
     *
     * @param \Cortex\Bookings\Models\Event        $event
     * @param \Cortex\Bookings\Models\EventBooking $eventBooking
     *
     * @return \Illuminate\View\View
     */
    public function edit(Event $event, EventBooking $eventBooking)
    {
        return $this->form($event, $eventBooking);
    }

    /**
     * Show event create/edit form.
     *
     * @param \Cortex\Bookings\Models\Event        $event
     * @param \Cortex\Bookings\Models\EventBooking $eventBooking
     *
     * @return \Illuminate\View\View
     */
    protected function form(Event $event, EventBooking $eventBooking)
    {
        $tickets = $event->tickets->pluck('name', 'id');
        $customers = app('rinvex.contacts.contact')->all()->pluck('full_name', 'id');

        return view('cortex/bookings::adminarea.pages.event_booking', compact('event', 'eventBooking', 'tickets', 'customers'));
    }

    /**
     * Store new event.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\EventBookingFormRequest $request
     * @param \Cortex\Bookings\Models\Event                                    $event
     * @param \Cortex\Bookings\Models\EventBooking                             $eventBooking
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(EventBookingFormRequest $request, Event $event, EventBooking $eventBooking)
    {
        return $this->process($request, $event, $eventBooking);
    }

    /**
     * Update given event.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\EventBookingFormRequest $request
     * @param \Cortex\Bookings\Models\Event                                    $event
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(EventBookingFormRequest $request, Event $event, EventBooking $eventBooking)
    {
        return $this->process($request, $event, $eventBooking);
    }

    /**
     * Process stored/updated event.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\Event           $event
     * @param \Cortex\Bookings\Models\EventBooking    $eventBooking
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Event $event, EventBooking $eventBooking)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save event
        $eventBooking->fill($data)->save();

        return intend([
            'url' => route('adminarea.events.bookings.index', ['event' => $event]),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/bookings::common.event_booking'), 'identifier' => $eventBooking->name])],
        ]);
    }

    /**
     * Destroy given event.
     *
     * @param \Cortex\Bookings\Models\Event        $event
     * @param \Cortex\Bookings\Models\EventBooking $eventBooking
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event, EventBooking $eventBooking)
    {
        $event->bookings()->where($eventBooking->getKeyName(), $eventBooking->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.events.bookings.index', ['event' => $event]),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/bookings::common.event_booking'), 'identifier' => $eventBooking->name])],
        ]);
    }
}

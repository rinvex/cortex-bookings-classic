<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\EventTicket;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\DataTables\Adminarea\EventTicketsDataTable;
use Cortex\Bookings\Http\Requests\Adminarea\EventTicketFormRequest;

class EventTicketsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = EventTicket::class;

    /**
     * List all event tickets.
     *
     * @param \Cortex\Bookings\Models\Event                         $event
     * @param \Cortex\Bookings\DataTables\Adminarea\EventsDataTable $eventsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Event $event, EventTicketsDataTable $eventsDataTable)
    {
        return $eventsDataTable->with([
            'tabs' => 'adminarea.events.tabs',
            'id' => "adminarea-events-{$event->getRouteKey()}-tickets-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Create new event.
     *
     * @param \Cortex\Bookings\Models\Event       $event
     * @param \Cortex\Bookings\Models\EventTicket $eventTicket
     *
     * @return \Illuminate\View\View
     */
    public function create(Event $event, EventTicket $eventTicket)
    {
        return $this->form($event, $eventTicket);
    }

    /**
     * Edit given event.
     *
     * @param \Cortex\Bookings\Models\Event       $event
     * @param \Cortex\Bookings\Models\EventTicket $eventTicket
     *
     * @return \Illuminate\View\View
     */
    public function edit(Event $event, EventTicket $eventTicket)
    {
        return $this->form($event, $eventTicket);
    }

    /**
     * Show event create/edit form.
     *
     * @param \Cortex\Bookings\Models\Event       $event
     * @param \Cortex\Bookings\Models\EventTicket $eventTicket
     *
     * @return \Illuminate\View\View
     */
    protected function form(Event $event, EventTicket $eventTicket)
    {
        return view('cortex/bookings::adminarea.pages.event_ticket', compact('event', 'eventTicket'));
    }

    /**
     * Store new event.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\EventTicketFormRequest $request
     * @param \Cortex\Bookings\Models\Event                                   $event
     * @param \Cortex\Bookings\Models\EventTicket                             $eventTicket
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(EventTicketFormRequest $request, Event $event, EventTicket $eventTicket)
    {
        return $this->process($request, $event, $eventTicket);
    }

    /**
     * Update given event.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\EventTicketFormRequest $request
     * @param \Cortex\Bookings\Models\Event                                   $event
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(EventTicketFormRequest $request, Event $event, EventTicket $eventTicket)
    {
        return $this->process($request, $event, $eventTicket);
    }

    /**
     * Process stored/updated event.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\Event           $event
     * @param \Cortex\Bookings\Models\EventTicket     $eventTicket
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Event $event, EventTicket $eventTicket)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save event
        $eventTicket->fill($data)->save();

        return intend([
            'url' => route('adminarea.events.tickets.index', ['event' => $event]),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/bookings::common.event_ticket'), 'identifier' => $eventTicket->name])],
        ]);
    }

    /**
     * Destroy given event.
     *
     * @param \Cortex\Bookings\Models\Event       $event
     * @param \Cortex\Bookings\Models\EventTicket $eventTicket
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event, EventTicket $eventTicket)
    {
        $event->tickets()->where($eventTicket->getKeyName(), $eventTicket->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.events.tickets.index', ['event' => $event]),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/bookings::common.event_ticket'), 'identifier' => $eventTicket->name])],
        ]);
    }
}

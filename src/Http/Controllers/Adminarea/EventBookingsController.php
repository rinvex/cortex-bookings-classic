<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\EventBooking;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
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
     * Import contacts.
     *
     * @TODO: Refactor required! Do we need import for bookings? Yes? refactor then!
     *
     * @param \Cortex\Contacts\Models\Contact                      $contact
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Contact $contact, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $contact,
            'tabs' => 'adminarea.contacts.tabs',
            'url' => route('adminarea.contacts.stash'),
            'id' => "adminarea-contacts-{$contact->getRouteKey()}-import-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash events.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     * @param \Cortex\Bookings\Models\Event                      $event
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, DefaultImporter $importer, Event $event)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * Hoard event bookings.
     *
     * @TODO: refactor this as it's wrong!
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function hoard(ImportFormRequest $request)
    {
        foreach ((array) $request->get('selected_ids') as $recordId) {
            $record = app('cortex.foundation.import_record')->find($recordId);

            try {
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.bookings.eventBooking')->getFillable()))->toArray();

                tap(app('rinvex.bookings.eventBooking')->firstOrNew($fillable), function ($instance) use ($record) {
                    $instance->save() && $record->delete();
                });
            } catch (Exception $exception) {
                $record->notes = $exception->getMessage().(method_exists($exception, 'getMessageBag') ? "\n".json_encode($exception->getMessageBag())."\n\n" : '');
                $record->status = 'fail';
                $record->save();
            }
        }

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/foundation::messages.import_complete')],
        ]);
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

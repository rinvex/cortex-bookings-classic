<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Managerarea;

use Cortex\Bookings\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Bookings\DataTables\Managerarea\EventsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Managerarea\EventFormRequest;

class EventsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Event::class;

    /**
     * List all events.
     *
     * @param \Cortex\Bookings\DataTables\Managerarea\EventsDataTable $eventsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(EventsDataTable $eventsDataTable)
    {
        return $eventsDataTable->with([
            'id' => 'managerarea-events-index-table',
            'phrase' => trans('cortex/bookings::common.events'),
        ])->render('cortex/foundation::managerarea.pages.datatable');
    }

    /**
     * List event logs.
     *
     * @param \Cortex\Bookings\Models\Event               $event
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Event $event, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $event,
            'tabs' => 'managerarea.events.tabs',
            'phrase' => trans('cortex/bookings::common.events'),
            'id' => "managerarea-events-{$event->getKey()}-logs-table",
        ])->render('cortex/foundation::managerarea.pages.datatable-logs');
    }

    /**
     * Import events.
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('cortex/foundation::managerarea.pages.import', [
            'id' => 'managerarea-events-import',
            'tabs' => 'managerarea.events.tabs',
            'url' => route('managerarea.events.hoard'),
            'phrase' => trans('cortex/bookings::common.events'),
        ]);
    }

    /**
     * Hoard events.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function hoard(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * List event import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => 'event',
            'tabs' => 'managerarea.events.tabs',
            'id' => 'managerarea-events-import-logs-table',
            'phrase' => trans('cortex/events::common.events'),
        ])->render('cortex/foundation::managerarea.pages.datatable-import-logs');
    }

    /**
     * Create new event.
     *
     * @param \Cortex\Bookings\Models\Event $event
     *
     * @return \Illuminate\View\View
     */
    public function create(Event $event)
    {
        return $this->form($event);
    }

    /**
     * Edit given event.
     *
     * @param \Cortex\Bookings\Models\Event $event
     *
     * @return \Illuminate\View\View
     */
    public function edit(Event $event)
    {
        return $this->form($event);
    }

    /**
     * Show event create/edit form.
     *
     * @param \Cortex\Bookings\Models\Event $event
     *
     * @return \Illuminate\View\View
     */
    protected function form(Event $event)
    {
        $tags = app('rinvex.tags.tag')->pluck('title', 'id');

        return view('cortex/bookings::managerarea.pages.event', compact('event', 'tags'));
    }

    /**
     * Store new event.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\EventFormRequest $request
     * @param \Cortex\Bookings\Models\Event                               $event
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(EventFormRequest $request, Event $event)
    {
        return $this->process($request, $event);
    }

    /**
     * Update given event.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\EventFormRequest $request
     * @param \Cortex\Bookings\Models\Event                               $event
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(EventFormRequest $request, Event $event)
    {
        return $this->process($request, $event);
    }

    /**
     * Process stored/updated event.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\Event           $event
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Event $event)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save event
        $event->fill($data)->save();

        return intend([
            'url' => route('managerarea.events.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'event', 'id' => $event->name])],
        ]);
    }

    /**
     * Destroy given event.
     *
     * @param \Cortex\Bookings\Models\Event $event
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return intend([
            'url' => route('managerarea.events.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'event', 'id' => $event->name])],
        ]);
    }
}

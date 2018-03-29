<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Bookings\DataTables\Adminarea\EventsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Adminarea\EventFormRequest;

class EventsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Event::class;

    /**
     * List all events.
     *
     * @param \Cortex\Bookings\DataTables\Adminarea\EventsDataTable $eventsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(EventsDataTable $eventsDataTable)
    {
        return $eventsDataTable->with([
            'id' => 'adminarea-events-index-table',
            'phrase' => trans('cortex/bookings::common.events'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
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
            'tabs' => 'adminarea.events.tabs',
            'phrase' => trans('cortex/bookings::common.events'),
            'id' => "adminarea-events-{$event->getKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Import events.
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('cortex/foundation::adminarea.pages.import', [
            'id' => 'adminarea-events-import',
            'tabs' => 'adminarea.events.tabs',
            'url' => route('adminarea.events.hoard'),
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
            'tabs' => 'adminarea.events.tabs',
            'id' => 'adminarea-events-import-logs-table',
            'phrase' => trans('cortex/events::common.events'),
        ])->render('cortex/foundation::adminarea.pages.datatable-import-logs');
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

        return view('cortex/bookings::adminarea.pages.event', compact('event', 'tags'));
    }

    /**
     * Store new event.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\EventFormRequest $request
     * @param \Cortex\Bookings\Models\Event                             $event
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
     * @param \Cortex\Bookings\Http\Requests\Adminarea\EventFormRequest $request
     * @param \Cortex\Bookings\Models\Event                             $event
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

        ! $request->hasFile('profile_picture')
        || $event->addMediaFromRequest('profile_picture')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('profile_picture', config('cortex.auth.media.disk'));

        ! $request->hasFile('cover_photo')
        || $event->addMediaFromRequest('cover_photo')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('cover_photo', config('cortex.auth.media.disk'));

        // Save event
        $event->fill($data)->save();

        return intend([
            'url' => route('adminarea.events.index'),
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
            'url' => route('adminarea.events.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'event', 'id' => $event->name])],
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Exception;
use Cortex\Bookings\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
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
            'id' => 'adminarea-cortex-bookings-events-index',
        ])->render('cortex/foundation::adminarea.pages.datatable-index');
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
            'id' => "adminarea-cortex-bookings-events-{$event->getRouteKey()}-logs",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import events.
     *
     * @param \Cortex\Bookings\Models\Event                        $event
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Event $event, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $event,
            'tabs' => 'adminarea.events.tabs',
            'url' => route('adminarea.events.stash'),
            'id' => "adminarea-cortex-bookings-events-{$event->getRouteKey()}-import",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash events.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function stash(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * Hoard events.
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
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.events.event')->getFillable()))->toArray();

                tap(app('rinvex.events.event')->firstOrNew($fillable), function ($instance) use ($record) {
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
     * List event import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => trans('cortex/bookings::common.event'),
            'tabs' => 'adminarea.events.tabs',
            'id' => 'adminarea-cortex-bookings-events-import-logs',
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
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
        $tags = app('rinvex.tags.tag')->pluck('name', 'id');
        $event->duration = (optional($event->starts_at)->format(config('app.date_format')) ?? date(config('app.date_format'))).' - '.(optional($event->ends_at)->format(config('app.date_format')) ?? date(config('app.date_format')));

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
                  ->toMediaCollection('profile_picture', config('cortex.foundation.media.disk'));

        ! $request->hasFile('cover_photo')
        || $event->addMediaFromRequest('cover_photo')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('cover_photo', config('cortex.foundation.media.disk'));

        // Save event
        $event->fill($data)->save();

        return intend([
            'url' => route('adminarea.events.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/bookings::common.event'), 'identifier' => $event->name])],
        ]);
    }

    /**
     * Destroy given event.
     *
     * @param \Cortex\Bookings\Models\Event $event
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return intend([
            'url' => route('adminarea.events.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/bookings::common.event'), 'identifier' => $event->name])],
        ]);
    }
}

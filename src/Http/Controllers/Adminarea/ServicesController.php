<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Exception;
use Cortex\Bookings\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Bookings\DataTables\Adminarea\ServicesDataTable;
use Cortex\Foundation\DataTables\ImportRecordsDataTable;
use Cortex\Bookings\Http\Requests\Adminarea\ServiceFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class ServicesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Service::class;

    /**
     * List all services.
     *
     * @param \Cortex\Bookings\DataTables\Adminarea\ServicesDataTable $servicesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ServicesDataTable $servicesDataTable)
    {
        return $servicesDataTable->with([
            'id' => 'adminarea-services-index-table',
        ])->render('cortex/foundation::adminarea.pages.datatable-index');
    }

    /**
     * List service logs.
     *
     * @param \Cortex\Bookings\Models\Service                $service
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Service $service, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $service,
            'tabs' => 'adminarea.services.tabs',
            'id' => "adminarea-services-{$service->getRouteKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Import services.
     *
     * @param \Cortex\Bookings\Models\Service                         $service
     * @param \Cortex\Foundation\DataTables\ImportRecordsDataTable $importRecordsDataTable
     *
     * @return \Illuminate\View\View
     */
    public function import(Service $service, ImportRecordsDataTable $importRecordsDataTable)
    {
        return $importRecordsDataTable->with([
            'resource' => $service,
            'tabs' => 'adminarea.services.tabs',
            'url' => route('adminarea.services.stash'),
            'id' => "adminarea-services-{$service->getRouteKey()}-import-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Stash services.
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
     * Hoard services.
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
                $fillable = collect($record['data'])->intersectByKeys(array_flip(app('rinvex.bookings.service')->getFillable()))->toArray();

                tap(app('rinvex.bookings.service')->firstOrNew($fillable), function ($instance) use ($record) {
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
     * List service import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => trans('cortex/bookings::common.service'),
            'tabs' => 'adminarea.services.tabs',
            'id' => 'adminarea-services-import-logs-table',
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Create new service.
     *
     * @param \Cortex\Bookings\Models\Service $service
     *
     * @return \Illuminate\View\View
     */
    public function create(Service $service)
    {
        return $this->form($service);
    }

    /**
     * Edit given service.
     *
     * @param \Cortex\Bookings\Models\Service $service
     *
     * @return \Illuminate\View\View
     */
    public function edit(Service $service)
    {
        return $this->form($service);
    }

    /**
     * Show service create/edit form.
     *
     * @param \Cortex\Bookings\Models\Service $service
     *
     * @return \Illuminate\View\View
     */
    protected function form(Service $service)
    {
        $tags = app('rinvex.tags.tag')->pluck('name', 'id');

        return view('cortex/bookings::adminarea.pages.service', compact('service', 'tags'));
    }

    /**
     * Store new service.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\ServiceFormRequest $request
     * @param \Cortex\Bookings\Models\Service                             $service
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(ServiceFormRequest $request, Service $service)
    {
        return $this->process($request, $service);
    }

    /**
     * Update given service.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\ServiceFormRequest $request
     * @param \Cortex\Bookings\Models\Service                             $service
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ServiceFormRequest $request, Service $service)
    {
        return $this->process($request, $service);
    }

    /**
     * Process stored/updated service.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\Service            $service
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Service $service)
    {
        // Prepare required input fields
        $data = $request->validated();

        ! $request->hasFile('profile_picture')
        || $service->addMediaFromRequest('profile_picture')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('profile_picture', config('cortex.auth.media.disk'));

        ! $request->hasFile('cover_photo')
        || $service->addMediaFromRequest('cover_photo')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('cover_photo', config('cortex.auth.media.disk'));

        // Save service
        $service->fill($data)->save();

        return intend([
            'url' => route('adminarea.services.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => trans('cortex/bookings::common.service'), 'identifier' => $service->name])],
        ]);
    }

    /**
     * Destroy given service.
     *
     * @param \Cortex\Bookings\Models\Service $service
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return intend([
            'url' => route('adminarea.services.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/bookings::common.service'), 'identifier' => $service->name])],
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Service;
use Cortex\Bookings\Models\ServiceBooking;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest;
use Cortex\Bookings\DataTables\Adminarea\ServiceBookingsDataTable;

class ServiceBookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = ServiceBooking::class;

    /**
     * {@inheritdoc}
     */
    public function authorizeResource($model, $parameter = null, array $options = [], $request = null): void
    {
        $middleware = [];
        $parameter = $parameter ?: snake_case(class_basename($model));

        foreach ($this->mapResourceAbilities() as $method => $ability) {
            $modelName = in_array($method, $this->resourceMethodsWithoutModels()) ? $model : $parameter;

            $middleware["can:update,{$modelName}"][] = $method;
            $middleware["can:{$ability},bookings"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * List all services.
     *
     * @param \Cortex\Bookings\Models\Service                         $service
     * @param \Cortex\Bookings\DataTables\Adminarea\ServicesDataTable $servicesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Service $service, ServiceBookingsDataTable $servicesDataTable)
    {
        return $servicesDataTable->with([
            'resource' => $service,
            'tabs' => 'adminarea.services.tabs',
            'id' => "adminarea-services-{$service->getRouteKey()}-bookings-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * List service logs.
     *
     * @param \Cortex\Bookings\Models\Service             $service
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
     * @param \Cortex\Bookings\Models\Service                      $service
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
     * Show service create/edit form.
     *
     * @param \Cortex\Bookings\Models\Service $service
     *
     * @return \Illuminate\View\View
     */
    protected function form(Service $service)
    {
        $tags = app('rinvex.tags.tag')->pluck('name', 'id');

        $days = [
            'sunday' => trans('cortex/bookings::common.sunday'),
            'monday' => trans('cortex/bookings::common.monday'),
            'tuesday' => trans('cortex/bookings::common.tuesday'),
            'wednesday' => trans('cortex/bookings::common.wednesday'),
            'thursday' => trans('cortex/bookings::common.thursday'),
            'friday' => trans('cortex/bookings::common.friday'),
            'saturday' => trans('cortex/bookings::common.saturday'),
        ];

        $weeks = collect(range(1, 52))->mapWithKeys(function ($asd) {
            return ['week'.str_pad((string) $asd, 2, '0', STR_PAD_LEFT) => trans('cortex/bookings::common.week').' '.str_pad((string) $asd, 2, '0', STR_PAD_LEFT)];
        })->toArray();

        $months = [
            'january' => trans('cortex/bookings::common.january'),
            'february' => trans('cortex/bookings::common.february'),
            'march' => trans('cortex/bookings::common.march'),
            'april' => trans('cortex/bookings::common.april'),
            'may' => trans('cortex/bookings::common.may'),
            'june' => trans('cortex/bookings::common.june'),
            'july' => trans('cortex/bookings::common.july'),
            'august' => trans('cortex/bookings::common.august'),
            'september' => trans('cortex/bookings::common.september'),
            'october' => trans('cortex/bookings::common.october'),
            'november' => trans('cortex/bookings::common.november'),
            'december' => trans('cortex/bookings::common.december'),
        ];

        $ranges = [
            'datetimes' => trans('cortex/bookings::common.datetimes'),
            'dates' => trans('cortex/bookings::common.dates'),
            'months' => trans('cortex/bookings::common.months'),
            'weeks' => trans('cortex/bookings::common.weeks'),
            'days' => trans('cortex/bookings::common.days'),
            trans('cortex/bookings::common.time_range') => array_merge([
                'times' => trans('cortex/bookings::common.times'),
            ], $days),
        ];

        return view('cortex/bookings::adminarea.pages.service', compact('service', 'tags', 'days', 'weeks', 'months', 'ranges'));
    }

    /**
     * Store new booking.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest $request
     *
     * @return int
     */
    public function store(BookingFormRequest $request): int
    {
        return $this->process($request, app('cortex.bookings.service_booking'));
    }

    /**
     * Update given booking.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\BookingFormRequest $request
     * @param \Cortex\Bookings\Models\ServiceBooking                      $serviceBooking
     *
     * @return int
     */
    public function update(BookingFormRequest $request, ServiceBooking $serviceBooking): int
    {
        return $this->process($request, $serviceBooking);
    }

    /**
     * Process stored/updated booking.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\ServiceBooking  $serviceBooking
     *
     * @return int
     */
    protected function process(FormRequest $request, ServiceBooking $serviceBooking): int
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save booking
        $serviceBooking->fill($data)->save();

        return $serviceBooking->getKey();
    }

    /**
     * Destroy given booking.
     *
     * @param \Cortex\Bookings\Models\Service        $service
     * @param \Cortex\Bookings\Models\ServiceBooking $serviceBooking
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service, ServiceBooking $serviceBooking)
    {
        $service->bookings()->where($serviceBooking->getKeyName(), $serviceBooking->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.services.bookings.index'),
            'with' => [
                'warning' => trans('cortex/foundation::messages.resource_deleted', [
                    'resource' => trans('cortex/bookings::common.service_booking'),
                    'identifier' => $service->name.':'.$serviceBooking->id,
                ]),
            ],
        ]);

        return $serviceBooking->getKey();
    }
}

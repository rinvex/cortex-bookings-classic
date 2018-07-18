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

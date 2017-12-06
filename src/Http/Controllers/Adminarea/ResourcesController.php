<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Illuminate\Http\Request;
use Cortex\Bookings\Contracts\ResourceContract;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Bookings\DataTables\Adminarea\ResourcesDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Adminarea\ResourceFormRequest;

class ResourcesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'resources';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Bookings\DataTables\Adminarea\ResourcesDataTable $resourcesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ResourcesDataTable $resourcesDataTable)
    {
        return $resourcesDataTable->with([
            'id' => 'cortex-bookings-resources',
            'phrase' => trans('cortex/bookings::common.resources'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Display a listing of the resource logs.
     *
     * @param \Cortex\Bookings\Contracts\ResourceContract $resource
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function logs(ResourceContract $resource, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'tab' => 'logs',
            'type' => 'resources',
            'resource' => $resource,
            'id' => 'cortex-bookings-resources-logs',
            'phrase' => trans('cortex/bookings::common.resources'),
        ])->render('cortex/foundation::adminarea.pages.datatable-tab');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\ResourceFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ResourceFormRequest $request)
    {
        return $this->process($request, app('cortex.bookings.resource'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\ResourceFormRequest $request
     * @param \Cortex\Bookings\Contracts\ResourceContract                  $resource
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ResourceFormRequest $request, ResourceContract $resource)
    {
        return $this->process($request, $resource);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Bookings\Contracts\ResourceContract $resource
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(ResourceContract $resource)
    {
        $resource->delete();

        return intend([
            'url' => route('adminarea.resources.index'),
            'with' => ['warning' => trans('cortex/bookings::messages.resource.deleted', ['slug' => $resource->slug])],
        ]);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Cortex\Bookings\Contracts\ResourceContract $resource
     *
     * @return \Illuminate\Http\Response
     */
    public function form(ResourceContract $resource)
    {
        return view('cortex/bookings::adminarea.forms.resource', compact('resource'));
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Http\Request                    $request
     * @param \Cortex\Bookings\Contracts\ResourceContract $resource
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(Request $request, ResourceContract $resource)
    {
        // Prepare required input fields
        $data = $request->all();

        // Save resource
        $resource->fill($data)->save();

        return intend([
            'url' => route('adminarea.resources.index'),
            'with' => ['success' => trans('cortex/bookings::messages.resource.saved', ['slug' => $resource->slug])],
        ]);
    }
}

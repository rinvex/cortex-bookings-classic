<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Event;
use Cortex\Bookings\Models\Ticketing;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Cortex\Bookings\DataTables\Adminarea\TicketingDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class EventBookingsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Event::class;

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
            $middleware["can:{$ability},ticketing"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * List event ticketing.
     *
     * @param \Cortex\Bookings\Models\Event                    $event
     * @param \Cortex\Foundation\DataTables\TicketingDataTable $ticketingDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Event $event, TicketingDataTable $ticketingDataTable)
    {
        return $ticketingDataTable->with([
            'resource' => $event,
            'tabs' => 'adminarea.events.tabs',
            'id' => "adminarea-events-{$event->getRouteKey()}-ticketing-table",
            'url' => route('adminarea.events.ticketing.store', ['event' => $event]),
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Store new event ticketing.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Cortex\Bookings\Models\Event                     $event
     *
     * @return void
     */
    public function store(ImageFormRequest $request, Event $event): void
    {
        $event->addTicketingFromRequest('file')
             ->sanitizingFileName(function ($fileName) {
                 return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
             })
             ->toTicketingCollection('default', config('cortex.bookings.ticketing.disk'));
    }

    /**
     * Destroy given event ticketing.
     *
     * @param \Cortex\Bookings\Models\Event     $event
     * @param \Cortex\Bookings\Models\Ticketing $ticketing
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event, Ticketing $ticketing)
    {
        $event->ticketing()->where($ticketing->getKeyName(), $ticketing->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.events.ticketing.index', ['event' => $event]),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'ticketing', 'identifier' => $ticketing->getRouteKey()])],
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Managerarea;

use Cortex\Bookings\Contracts\RoomContract;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Bookings\DataTables\Managerarea\RoomsDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Bookings\Http\Requests\Managerarea\RoomFormRequest;

class RoomsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'rooms';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Bookings\DataTables\Managerarea\RoomsDataTable $roomsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(RoomsDataTable $roomsDataTable)
    {
        return $roomsDataTable->with([
            'id' => 'cortex-rooms',
            'phrase' => trans('cortex/bookings::common.rooms'),
        ])->render('cortex/tenants::managerarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logs(RoomContract $room)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(LogsDataTable::class)->with(['resource' => $room])->ajax()
            : intend(['url' => route('adminarea.rooms.edit', ['room' => $room]).'#logs-tab']);
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     *
     * @return \Illuminate\Http\Response
     */
    public function form(RoomContract $room)
    {
        $logs = app(LogsDataTable::class)->with(['id' => 'logs-table'])->html()->minifiedAjax(route('managerarea.rooms.logs', ['room' => $room]));

        return view('cortex/bookings::managerarea.pages.room', compact('room', 'logs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\RoomFormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoomFormRequest $request)
    {
        return $this->process($request, app('cortex.bookings.room'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\RoomFormRequest $request
     * @param \Cortex\Bookings\Contracts\RoomContract                    $room
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoomFormRequest $request, RoomContract $room)
    {
        return $this->process($request, $room);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     *
     * @return \Illuminate\Http\Response
     */
    protected function process(FormRequest $request, RoomContract $room)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save room
        $room->fill($data)->save();

        return intend([
            'url' => route('managerarea.rooms.index'),
            'with' => ['success' => trans('cortex/bookings::messages.room.saved', ['slug' => $room->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(RoomContract $room)
    {
        $room->delete();

        return intend([
            'url' => route('managerarea.rooms.index'),
            'with' => ['warning' => trans('cortex/bookings::messages.room.deleted', ['slug' => $room->slug])],
        ]);
    }
}

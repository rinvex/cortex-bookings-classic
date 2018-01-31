<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Bookings\DataTables\Adminarea\RoomsDataTable;
use Cortex\Bookings\Http\Requests\Adminarea\RoomFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class RoomsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'rooms';

    /**
     * Display a listing of the resource.
     *
     * @param \Cortex\Bookings\DataTables\Adminarea\RoomsDataTable $roomsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(RoomsDataTable $roomsDataTable)
    {
        return $roomsDataTable->with([
            'id' => 'adminarea-rooms-index-table',
            'phrase' => trans('cortex/bookings::common.rooms'),
        ])->render('cortex/foundation::adminarea.pages.datatable');
    }

    /**
     * Get a listing of the resource logs.
     *
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Room $room, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $room,
            'tabs' => 'adminarea.rooms.tabs',
            'phrase' => trans('cortex/bookings::common.rooms'),
            'id' => "adminarea-rooms-{$room->getKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Show the form for create/update of the given resource.
     *
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\View\View
     */
    public function form(Room $room)
    {
        return view('cortex/bookings::adminarea.pages.room', compact('room'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\RoomFormRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(RoomFormRequest $request)
    {
        return $this->process($request, app('cortex.bookings.room'));
    }

    /**
     * Update the given resource in storage.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\RoomFormRequest $request
     * @param \Cortex\Bookings\Models\Room                             $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(RoomFormRequest $request, Room $room)
    {
        return $this->process($request, $room);
    }

    /**
     * Process the form for store/update of the given resource.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Bookings\Models\Room            $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Room $room)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save room
        $room->fill($data)->save();

        return intend([
            'url' => route('adminarea.rooms.index'),
            'with' => ['success' => trans('cortex/bookings::messages.room.saved', ['slug' => $room->slug])],
        ]);
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(Room $room)
    {
        $room->delete();

        return intend([
            'url' => route('adminarea.rooms.index'),
            'with' => ['warning' => trans('cortex/bookings::messages.room.deleted', ['slug' => $room->slug])],
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Managerarea;

use Cortex\Bookings\Models\Room;
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
    protected $resource = 'room';

    /**
     * List all rooms.
     *
     * @param \Cortex\Bookings\DataTables\Managerarea\RoomsDataTable $roomsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(RoomsDataTable $roomsDataTable)
    {
        return $roomsDataTable->with([
            'id' => 'managerarea-rooms-index-table',
            'phrase' => trans('cortex/bookings::common.rooms'),
        ])->render('cortex/tenants::managerarea.pages.datatable');
    }

    /**
     * List room logs.
     *
     * @param \Cortex\Bookings\Models\Room                $room
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Room $room, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $room,
            'tabs' => 'managerarea.rooms.tabs',
            'phrase' => trans('cortex/bookings::common.rooms'),
            'id' => "managerarea-rooms-{$room->getKey()}-logs-table",
        ])->render('cortex/tenants::managerarea.pages.datatable-logs');
    }

    /**
     * Create new room.
     *
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\View\View
     */
    public function create(Room $room)
    {
        return $this->form($room);
    }

    /**
     * Edit given room.
     *
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\View\View
     */
    public function edit(Room $room)
    {
        return $this->form($room);
    }

    /**
     * Show room create/edit form.
     *
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\View\View
     */
    protected function form(Room $room)
    {
        return view('cortex/bookings::managerarea.pages.room', compact('room'));
    }

    /**
     * Store new room.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\RoomFormRequest $request
     * @param \Cortex\Bookings\Models\Room                               $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(RoomFormRequest $request, Room $room)
    {
        return $this->process($request, $room);
    }

    /**
     * Update given room.
     *
     * @param \Cortex\Bookings\Http\Requests\Managerarea\RoomFormRequest $request
     * @param \Cortex\Bookings\Models\Room                               $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(RoomFormRequest $request, Room $room)
    {
        return $this->process($request, $room);
    }

    /**
     * Process stored/updated room.
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
            'url' => route('managerarea.rooms.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'room', 'id' => $room->slug])],
        ]);
    }

    /**
     * Destroy given room.
     *
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return intend([
            'url' => route('managerarea.rooms.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'room', 'id' => $room->slug])],
        ]);
    }
}

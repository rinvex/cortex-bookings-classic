<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Cortex\Bookings\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Bookings\DataTables\Adminarea\RoomsDataTable;
use Cortex\Bookings\Http\Requests\Adminarea\RoomFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class RoomsController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Room::class;

    /**
     * List all rooms.
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
            'tabs' => 'adminarea.rooms.tabs',
            'phrase' => trans('cortex/bookings::common.rooms'),
            'id' => "adminarea-rooms-{$room->getRouteKey()}-logs-table",
        ])->render('cortex/foundation::adminarea.pages.datatable-logs');
    }

    /**
     * Import rooms.
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('cortex/foundation::adminarea.pages.import', [
            'id' => 'adminarea-rooms-import',
            'tabs' => 'adminarea.rooms.tabs',
            'url' => route('adminarea.rooms.hoard'),
            'phrase' => trans('cortex/bookings::common.rooms'),
        ]);
    }

    /**
     * Hoard rooms.
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
     * List room import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => 'room',
            'tabs' => 'adminarea.rooms.tabs',
            'id' => 'adminarea-rooms-import-logs-table',
            'phrase' => trans('cortex/rooms::common.rooms'),
        ])->render('cortex/foundation::adminarea.pages.datatable-import-logs');
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
        $tags = app('rinvex.tags.tag')->pluck('name', 'id');

        return view('cortex/bookings::adminarea.pages.room', compact('room', 'tags'));
    }

    /**
     * Store new room.
     *
     * @param \Cortex\Bookings\Http\Requests\Adminarea\RoomFormRequest $request
     * @param \Cortex\Bookings\Models\Room                             $room
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

        ! $request->hasFile('profile_picture')
        || $room->addMediaFromRequest('profile_picture')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('profile_picture', config('cortex.auth.media.disk'));

        ! $request->hasFile('cover_photo')
        || $room->addMediaFromRequest('cover_photo')
                  ->sanitizingFileName(function ($fileName) {
                      return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                  })
                  ->toMediaCollection('cover_photo', config('cortex.auth.media.disk'));

        // Save room
        $room->fill($data)->save();

        return intend([
            'url' => route('adminarea.rooms.index'),
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
            'url' => route('adminarea.rooms.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'room', 'id' => $room->slug])],
        ]);
    }
}

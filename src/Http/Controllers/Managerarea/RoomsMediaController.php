<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Managerarea;

use Spatie\MediaLibrary\Models\Media;
use Cortex\Bookings\Contracts\RoomContract;
use Cortex\Foundation\DataTables\MediaDataTable;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class RoomsMediaController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'rooms';

    /**
     * {@inheritdoc}
     */
    protected $resourceAbilityMap = [
        'index' => 'list-media',
        'store' => 'create-media',
        'delete' => 'delete-media',
    ];

    /**
     * Get a listing of the resource media.
     *
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function index(RoomContract $room)
    {
        return request()->ajax() && request()->wantsJson()
            ? app(MediaDataTable::class)->with(['resource' => $room])->ajax()
            : intend(['url' => route('managerarea.rooms.edit', ['room' => $room]).'#media-tab']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Cortex\Bookings\Contracts\RoomContract           $room
     *
     * @return void
     */
    public function store(ImageFormRequest $request, RoomContract $room): void
    {
        $room->addMediaFromRequest('file')
             ->sanitizingFileName(function ($fileName) {
                 return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
             })
             ->toMediaCollection('default', config('cortex.bookings.media.disk'));
    }

    /**
     * Delete the given resource from storage.
     *
     * @param \Cortex\Bookings\Contracts\RoomContract $room
     * @param \Spatie\MediaLibrary\Models\Media       $media
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function delete(RoomContract $room, Media $media)
    {
        $room->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('managerarea.rooms.media.index', ['room' => $room]),
            'with' => ['warning' => trans('cortex/bookings::messages.room.media_deleted')],
        ]);
    }
}

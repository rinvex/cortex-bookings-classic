<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Managerarea;

use Cortex\Bookings\Models\Room;
use Spatie\MediaLibrary\Models\Media;
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
     * @param \Cortex\Bookings\Models\Room $room
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Room $room, MediaDataTable $mediaDataTable)
    {
        return $mediaDataTable->with([
            'resource' => $room,
            'tabs' => 'managerarea.rooms.tabs',
            'phrase' => trans('cortex/bookings::common.rooms'),
            'id' => "managerarea-rooms-{$room->getKey()}-media-table",
            'url' => route('managerarea.rooms.media.store', ['room' => $room]),
        ])->render('cortex/tenants::managerarea.pages.datatable-media');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Cortex\Bookings\Models\Room                      $room
     *
     * @return void
     */
    public function store(ImageFormRequest $request, Room $room): void
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
     * @param \Cortex\Bookings\Models\Room      $room
     * @param \Spatie\MediaLibrary\Models\Media $media
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(Room $room, Media $media)
    {
        $room->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('managerarea.rooms.media.index', ['room' => $room]),
            'with' => ['warning' => trans('cortex/bookings::messages.room.media_deleted')],
        ]);
    }
}

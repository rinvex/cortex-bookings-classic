<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Illuminate\Support\Str;
use Cortex\Bookings\Models\Event;
use Cortex\Foundation\DataTables\MediaDataTable;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class EventMediaController extends AuthorizedController
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
        $parameter = $parameter ?: Str::snake(class_basename($model));

        foreach ($this->mapResourceAbilities() as $method => $ability) {
            $modelName = in_array($method, $this->resourceMethodsWithoutModels()) ? $model : $parameter;

            $middleware["can:update,{$modelName}"][] = $method;
            $middleware["can:{$ability},media"][] = $method;
        }

        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * List event media.
     *
     * @param \Cortex\Bookings\Models\Event                $event
     * @param \Cortex\Foundation\DataTables\MediaDataTable $mediaDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Event $event, MediaDataTable $mediaDataTable)
    {
        return $mediaDataTable->with([
            'resource' => $event,
            'tabs' => 'adminarea.events.tabs',
            'id' => "adminarea-cortex-bookings-events-{$event->getRouteKey()}-media",
            'url' => route('adminarea.events.media.store', ['event' => $event]),
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Store new event media.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Cortex\Bookings\Models\Event                     $event
     *
     * @return void
     */
    public function store(ImageFormRequest $request, Event $event): void
    {
        $event->addMediaFromRequest('file')
             ->sanitizingFileName(function ($fileName) {
                 return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
             })
             ->toMediaCollection('default', config('cortex.bookings.media.disk'));
    }

    /**
     * Destroy given event media.
     *
     * @param \Cortex\Bookings\Models\Event                      $event
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media $media
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event, Media $media)
    {
        $event->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.events.media.index', ['event' => $event]),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => $media->getRouteKey()])],
        ]);
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Http\Controllers\Adminarea;

use Illuminate\Support\Str;
use Cortex\Bookings\Models\Service;
use Cortex\Foundation\DataTables\MediaDataTable;
use Cortex\Foundation\Http\Requests\ImageFormRequest;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Cortex\Foundation\Http\Controllers\AuthorizedController;

class ServiceMediaController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Service::class;

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
     * List service media.
     *
     * @param \Cortex\Bookings\Models\Service              $service
     * @param \Cortex\Foundation\DataTables\MediaDataTable $mediaDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index(Service $service, MediaDataTable $mediaDataTable)
    {
        return $mediaDataTable->with([
            'resource' => $service,
            'tabs' => 'adminarea.services.tabs',
            'id' => "adminarea-services-{$service->getRouteKey()}-media-table",
            'url' => route('adminarea.services.media.store', ['service' => $service]),
        ])->render('cortex/foundation::adminarea.pages.datatable-dropzone');
    }

    /**
     * Store new service media.
     *
     * @param \Cortex\Foundation\Http\Requests\ImageFormRequest $request
     * @param \Cortex\Bookings\Models\Service                   $service
     *
     * @return void
     */
    public function store(ImageFormRequest $request, Service $service): void
    {
        $service->addMediaFromRequest('file')
             ->sanitizingFileName(function ($fileName) {
                 return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
             })
             ->toMediaCollection('default', config('cortex.bookings.media.disk'));
    }

    /**
     * Destroy given service media.
     *
     * @param \Cortex\Bookings\Models\Service                    $service
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media $media
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service, Media $media)
    {
        $service->media()->where($media->getKeyName(), $media->getKey())->first()->delete();

        return intend([
            'url' => route('adminarea.services.media.index', ['service' => $service]),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => strip_tags($media->getRouteKey())])],
        ]);
    }
}

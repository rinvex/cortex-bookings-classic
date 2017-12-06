<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Tenantarea;

use League\Fractal\TransformerAbstract;
use Cortex\Bookings\Contracts\ResourceContract;

class ResourceTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(ResourceContract $resource)
    {
        return [
            'name' => (string) $resource->name,
            'slug' => (string) $resource->slug,
            'is_active' => (bool) $resource->is_active,
            'price' => (string) $resource->price,
            'unit' => (string) trans('cortex/bookings::common.unit_'.$resource->unit),
            'currency' => (string) $resource->currency,
            'created_at' => (string) $resource->created_at,
            'updated_at' => (string) $resource->updated_at,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Cortex\Bookings\Models\Service;
use League\Fractal\TransformerAbstract;

class ServiceTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Service $service): array
    {
        return $this->escape([
            'id' => (string) $service->getRouteKey(),
            'name' => (string) $service->name,
            'base_cost' => (float) $service->base_cost,
            'unit_cost' => (float) $service->unit_cost,
            'unit' => (string) $service->unit,
            'currency' => (string) $service->currency,
            'sort_order' => (string) $service->sort_order,
            'created_at' => (string) $service->created_at,
            'updated_at' => (string) $service->updated_at,
        ]);
    }
}

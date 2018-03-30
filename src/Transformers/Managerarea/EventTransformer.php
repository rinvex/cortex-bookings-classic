<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Managerarea;

use Cortex\Bookings\Models\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Event $event): array
    {
        return [
            'id' => (string) $event->getRouteKey(),
            'name' => (string) $event->name,
            'base_cost' => (string) $event->base_cost,
            'unit_cost' => (string) $event->unit_cost,
            'unit' => (string) $event->unit,
            'currency' => (string) $event->currency,
            'sort_order' => (string) $event->sort_order,
            'created_at' => (string) $event->created_at,
            'updated_at' => (string) $event->updated_at,
        ];
    }
}

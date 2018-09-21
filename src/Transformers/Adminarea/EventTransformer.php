<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Adminarea;

use Cortex\Bookings\Models\Event;
use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Event $event): array
    {
        return $this->escape([
            'id' => (string) $event->getRouteKey(),
            'name' => (string) $event->name,
            'is_public' => (bool) $event->is_public,
            'starts_at' => (string) $event->starts_at,
            'ends_at' => (string) $event->ends_at,
            'timezone' => (string) $event->timezone,
            'created_at' => (string) $event->created_at,
            'updated_at' => (string) $event->updated_at,
        ]);
    }
}

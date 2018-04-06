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
        $reservations = 123;

        return $this->escape([
            'id' => (string) $event->getRouteKey(),
            'name' => (string) $event->name,
            'is_active' => (string) $event->is_active,
            'price' => (string) $event->price,
            'currency' => (string) $event->currency,
            'capacity' => (string) $reservations.' / '.$event->quantity,
            'created_at' => (string) $event->created_at,
            'updated_at' => (string) $event->updated_at,
        ]);
    }
}

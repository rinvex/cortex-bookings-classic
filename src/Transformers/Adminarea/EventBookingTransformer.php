<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Adminarea;

use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;
use Cortex\Bookings\Models\EventBooking;

class EventBookingTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(EventBooking $eventBooking): array
    {
        return $this->escape([
            'id' => (string) $eventBooking->getRouteKey(),
            'event_id' => (string) $eventBooking->bookable->getRouteKey(),
            'name' => (string) $eventBooking->name,
            'is_active' => (bool) $eventBooking->is_active,
            'price' => (string) $eventBooking->price,
            'currency' => (string) $eventBooking->currency,
            'quantity' => (string) $eventBooking->quantity,
            'created_at' => (string) $eventBooking->created_at,
            'updated_at' => (string) $eventBooking->updated_at,
        ]);
    }
}

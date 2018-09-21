<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Adminarea;

use Rinvex\Support\Traits\Escaper;
use Cortex\Bookings\Models\EventTicket;
use League\Fractal\TransformerAbstract;

class EventTicketTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(EventTicket $eventTicket): array
    {
        return $this->escape([
            'id' => (string) $eventTicket->getRouteKey(),
            'event_id' => (string) $eventTicket->ticketable->getRouteKey(),
            'name' => (string) $eventTicket->name,
            'is_active' => (bool) $eventTicket->is_active,
            'price' => (string) $eventTicket->price,
            'currency' => (string) $eventTicket->currency,
            'quantity' => (string) $eventTicket->quantity,
            'created_at' => (string) $eventTicket->created_at,
            'updated_at' => (string) $eventTicket->updated_at,
        ]);
    }
}

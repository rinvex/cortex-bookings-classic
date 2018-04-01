<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Adminarea;

use Cortex\Bookings\Models\Room;
use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;

class RoomTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Room $room): array
    {
        return $this->escape([
            'id' => (string) $room->getRouteKey(),
            'name' => (string) $room->name,
            'base_cost' => (string) $room->base_cost,
            'unit_cost' => (string) $room->unit_cost,
            'unit' => (string) $room->unit,
            'currency' => (string) $room->currency,
            'sort_order' => (string) $room->sort_order,
            'created_at' => (string) $room->created_at,
            'updated_at' => (string) $room->updated_at,
        ]);
    }
}

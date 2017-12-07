<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Tenantarea;

use League\Fractal\TransformerAbstract;
use Cortex\Bookings\Contracts\RoomContract;

class RoomTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(RoomContract $room)
    {
        return [
            'name' => (string) $room->name,
            'slug' => (string) $room->slug,
            'is_active' => (bool) $room->is_active,
            'price' => (string) $room->price,
            'unit' => (string) trans('cortex/bookings::common.unit_'.$room->unit),
            'currency' => (string) $room->currency,
            'created_at' => (string) $room->created_at,
            'updated_at' => (string) $room->updated_at,
        ];
    }
}

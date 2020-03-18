<?php

declare(strict_types=1);

namespace Cortex\Bookings\Transformers\Adminarea;

use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;
use Cortex\Bookings\Models\ServiceBooking;

class ServiceBookingTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * Transform event booking model.
     *
     * @param \Cortex\Bookings\Models\EventBooking $eventBooking
     *
     * @throws \Exception
     *
     * @return array
     */
    public function transform(ServiceBooking $serviceBooking): array
    {
        return $this->escape([
            'id' => (string) $serviceBooking->getRouteKey(),
            'DT_RowId' => 'row_'.$serviceBooking->getRouteKey(),
            'customer' => (object) $serviceBooking->customer,
            'price' => (float) $serviceBooking->price,
            'quantity' => (float) $serviceBooking->quantity,
            'total_paid' => (float) $serviceBooking->total_paid,
            'currency' => (string) $serviceBooking->currency,
            'formula' => (string) $serviceBooking->formula,
            'starts_at' => (string) $serviceBooking->starts_at,
            'ends_at' => (string) $serviceBooking->ends_at,
            'created_at' => (string) $serviceBooking->created_at,
            'updated_at' => (string) $serviceBooking->updated_at,
        ]);
    }
}

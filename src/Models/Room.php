<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Cortex\Foundation\Traits\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Cortex\Bookings\Models\Room.
 *
 * @property int                                                                             $id
 * @property string                                                                          $slug
 * @property array                                                                           $name
 * @property array                                                                           $description
 * @property bool                                                                            $is_active
 * @property mixed                                                                           $price
 * @property string                                                                          $unit
 * @property string                                                                          $currency
 * @property string                                                                          $style
 * @property int                                                                             $sort_order
 * @property bool                                                                            $multiple_bookings_allowed
 * @property bool                                                                            $multiple_bookings_bypassed
 * @property int                                                                             $multiple_bookings_allocation
 * @property int                                                                             $early_booking_limit
 * @property int                                                                             $late_booking_limit
 * @property int                                                                             $late_cancellation_limit
 * @property int                                                                             $maximum_booking_length
 * @property int                                                                             $minimum_booking_length
 * @property int                                                                             $booking_interval_limit
 * @property \Carbon\Carbon|null                                                             $created_at
 * @property \Carbon\Carbon|null                                                             $updated_at
 * @property \Carbon\Carbon                                                                  $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[]   $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Bookings\Models\Booking[] $bookings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Bookings\Models\Price[]   $prices
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Bookings\Models\Rate[]    $rates
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]        $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereBookingIntervalLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereEarlyBookingLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereLateBookingLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereLateCancellationLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereMaximumBookingLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereMinimumBookingLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereMultipleBookingsAllocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereMultipleBookingsAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereMultipleBookingsBypassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Room extends Bookable implements HasMedia
{
    use Auditable;
    use HasMediaTrait;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('cortex.bookings.tables.rooms'));
        $this->setRules([
            'slug' => 'required|alpha_dash|max:150|unique:'.config('cortex.bookings.tables.rooms').',slug',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:10000',
            'is_active' => 'sometimes|boolean',
            'price' => 'required|numeric',
            'unit' => 'required|string|in:m,h,d',
            'currency' => 'required|string|size:3',
            'style' => 'nullable|string|max:150',
            'sort_order' => 'nullable|integer|max:10000000',
            'multiple_bookings_allowed' => 'sometimes|boolean',
            'multiple_bookings_bypassed' => 'sometimes|boolean',
            'multiple_bookings_allocation' => 'nullable|integer|max:10000000',
            'early_booking_limit' => 'nullable|integer|max:10000',
            'late_booking_limit' => 'nullable|integer|max:10000',
            'late_cancellation_limit' => 'nullable|integer|max:10000',
            'maximum_booking_length' => 'nullable|integer|max:10000',
            'minimum_booking_length' => 'nullable|integer|max:10000',
            'booking_interval_limit' => 'nullable|integer|max:150',
        ]);
    }
}

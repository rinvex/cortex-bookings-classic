<?php

declare(strict_types=1);

namespace Cortex\Bookings\Contracts;

/**
 * Cortex\Bookings\Contracts\RoomContract.
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
 * @property int                                                                             $type
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rinvex\Bookings\Models\Price[]   $prices
 * @property-read \Illuminate\Database\Eloquent\Collection|\Rinvex\Bookings\Models\Rate[]    $rates
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]        $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Room inactive()
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
interface RoomContract
{
    //
}

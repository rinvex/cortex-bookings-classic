<?php

declare(strict_types=1);

namespace Cortex\Bookings\Contracts;

/**
 * Cortex\Bookings\Contracts\ResourceContract.
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource active()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource inactive()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereBookingIntervalLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereEarlyBookingLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereLateBookingLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereLateCancellationLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereMaximumBookingLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereMinimumBookingLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereMultipleBookingsAllocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereMultipleBookingsAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereMultipleBookingsBypassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Resource withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
interface ResourceContract
{
    //
}

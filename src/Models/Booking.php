<?php

namespace Cortex\Bookings\Models;

use Rinvex\Tenants\Traits\Tenantable;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Bookings\Models\Booking as BaseBooking;

/**
 * Cortex\Bookings\Models\Booking
 *
 * @property int                                                                           $id
 * @property int                                                                           $bookable_id
 * @property string                                                                        $bookable_type
 * @property int                                                                           $customer_id
 * @property string                                                                        $customer_type
 * @property \Carbon\Carbon                                                                $starts_at
 * @property \Carbon\Carbon                                                                $ends_at
 * @property float                                                                         $price
 * @property array                                                                         $price_equation
 * @property \Carbon\Carbon                                                                $cancelled_at
 * @property string                                                                        $notes
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $bookable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $customer
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]      $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking cancelled()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking cancelledAfter($date)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking cancelledBefore($date)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking cancelledBetween($starts, $ends)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking current()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking endsAfter($date)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking endsBefore($date)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking endsBetween($starts, $ends)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking future()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking ofBookable(\Illuminate\Database\Eloquent\Model $bookable)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking ofCustomer(\Illuminate\Database\Eloquent\Model $customer)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking past()
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking startsAfter($date)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking startsBefore($date)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Booking startsBetween($starts, $ends)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereCustomerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking wherePriceEquation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Booking withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Booking extends BaseBooking
{
    use Tenantable;
    use LogsActivity;
}

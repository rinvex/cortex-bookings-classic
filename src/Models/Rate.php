<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Rinvex\Tenants\Traits\Tenantable;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Bookings\Models\Rate as BaseRate;

/**
 * Cortex\Bookings\Models\Rate
 *
 * @property int                                                                           $id
 * @property int                                                                           $bookable_id
 * @property string                                                                        $bookable_type
 * @property int                                                                           $percentage
 * @property string                                                                        $operator
 * @property int                                                                           $amount
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $bookable
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]      $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate whereOperator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Rate withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Rate extends BaseRate
{
    use Tenantable;
    use LogsActivity;
}

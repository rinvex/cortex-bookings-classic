<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Rinvex\Tenants\Traits\Tenantable;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Bookings\Models\Price as BasePrice;

/**
 * Cortex\Bookings\Models\Price.
 *
 * @property int                                                                           $id
 * @property int                                                                           $bookable_id
 * @property string                                                                        $bookable_type
 * @property string                                                                        $day
 * @property \Carbon\Carbon                                                                $starts_at
 * @property \Carbon\Carbon                                                                $ends_at
 * @property float                                                                         $price
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $bookable
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]      $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Price withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Price extends BasePrice
{
    use Tenantable;
    use LogsActivity;
}

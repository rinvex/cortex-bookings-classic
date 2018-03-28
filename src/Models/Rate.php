<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Cortex\Foundation\Traits\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Bookings\Models\Rate as BaseRate;

/**
 * Cortex\Bookings\Models\Rate.
 *
 * @property int                                                                           $id
 * @property int                                                                           $bookable_id
 * @property string                                                                        $bookable_type
 * @property string                                                                        $range
 * @property string                                                                        $range_from
 * @property string                                                                        $range_to
 * @property float                                                                         $base_cost
 * @property string                                                                        $base_cost_modifier
 * @property float                                                                         $unit_cost
 * @property string                                                                        $unit_cost_modifier
 * @property int                                                                           $priority
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $bookable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereBaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereBaseCostModifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereRangeFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereRangeTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereUnitCostModifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Rate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Rate extends BaseRate
{
    use Auditable;
    use LogsActivity;
}

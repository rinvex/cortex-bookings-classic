<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Cortex\Foundation\Traits\Auditable;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Bookings\Models\Addon as BaseAddon;

/**
 * Rinvex\Bookings\Models\Addon.
 *
 * @property int                                                                           $id
 * @property int                                                                           $bookable_id
 * @property string                                                                        $bookable_type
 * @property string                                                                        $name
 * @property string                                                                        $title
 * @property string                                                                        $description
 * @property float                                                                         $base_cost
 * @property string                                                                        $base_cost_modifier
 * @property float                                                                         $unit_cost
 * @property string                                                                        $unit_cost_modifier
 * @property \Carbon\Carbon|null                                                           $created_at
 * @property \Carbon\Carbon|null                                                           $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[] $activity
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent                            $bookable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereBaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereBaseCostModifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereBookableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereBookableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereUnitCostModifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Rinvex\Bookings\Models\Addon whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Addon extends BaseAddon
{
    use Auditable;
    use LogsActivity;
}

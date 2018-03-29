<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Rinvex\Tags\Traits\Taggable;
use Rinvex\Bookings\Models\Bookable;
use Rinvex\Tenants\Traits\Tenantable;
use Cortex\Foundation\Traits\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Cortex\Bookings\Models\Event.
 *
 * @property int                                                                             $id
 * @property string                                                                          $name
 * @property array                                                                           $title
 * @property array                                                                           $description
 * @property bool                                                                            $is_active
 * @property mixed                                                                           $base_cost
 * @property mixed                                                                           $unit_cost
 * @property string                                                                          $currency
 * @property string                                                                          $unit
 * @property int                                                                             $maximum_units
 * @property int                                                                             $minimum_units
 * @property bool                                                                         $is_recurring
 * @property int                                                                             $sort_order
 * @property int                                                                             $capacity
 * @property string                                                                          $style
 * @property \Carbon\Carbon|null                                                             $created_at
 * @property \Carbon\Carbon|null                                                             $updated_at
 * @property \Carbon\Carbon                                                                  $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Foundation\Models\Log[]   $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Bookings\Models\Booking[] $bookings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cortex\Bookings\Models\Rate[]    $rates
 * @property \Illuminate\Database\Eloquent\Collection|\Cortex\Tenants\Models\Tenant[]        $tenants
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereBaseCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereIsRecurring($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereMaximumUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereMinimumUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereMultipleBookingsAllocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereMultipleBookingsAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereMultipleBookingsBypassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereStyle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event withAllTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event withAnyTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event withTenants($tenants, $group = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event withoutAnyTenants()
 * @method static \Illuminate\Database\Eloquent\Builder|\Cortex\Bookings\Models\Event withoutTenants($tenants, $group = null)
 * @mixin \Eloquent
 */
class Event extends Bookable implements HasMedia
{
    use Taggable;
    use Auditable;
    use Tenantable;
    use LogsActivity;
    use HasMediaTrait;

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logFillable = true;

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('cortex.bookings.tables.events'));
        $this->setRules([
            'name' => 'required|alpha_dash|max:150|unique:'.config('cortex.bookings.tables.events').',name',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:10000',
            'is_active' => 'sometimes|boolean',
            'base_cost' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            'currency' => 'required|string|size:3',
            'unit' => 'required|string|in:minute,hour,day,month',
            'maximum_units' => 'nullable|integer|max:10000',
            'minimum_units' => 'nullable|integer|max:10000',
            'is_recurring' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|max:10000000',
            'capacity' => 'nullable|integer|max:10000000',
            'style' => 'nullable|string|max:150',
            'tags' => 'nullable|array',
        ]);
    }

    /**
     * Register media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')->singleFile();
        $this->addMediaCollection('cover_photo')->singleFile();
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}

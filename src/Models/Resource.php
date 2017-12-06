<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Spatie\Sluggable\SlugOptions;
use Rinvex\Support\Traits\HasSlug;
use Rinvex\Bookings\Traits\Bookable;
use Rinvex\Tenants\Traits\Tenantable;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\HasTranslations;
use Rinvex\Support\Traits\ValidatingTrait;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Cortex\Bookings\Contracts\ResourceContract;

/**
 * Cortex\Bookings\Models\Resource.
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
class Resource extends Model implements ResourceContract, Sortable
{
    use HasSlug;
    use Bookable;
    use Tenantable;
    use LogsActivity;
    use SortableTrait;
    use HasTranslations;
    use ValidatingTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_active',
        'price',
        'unit',
        'currency',
        'style',
        'type',
        'sort_order',
        'multiple_bookings_allowed',
        'multiple_bookings_bypassed',
        'multiple_bookings_allocation',
        'early_booking_limit',
        'late_booking_limit',
        'late_cancellation_limit',
        'maximum_booking_length',
        'minimum_booking_length',
        'booking_interval_limit',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'slug' => 'string',
        'name' => 'string',
        'description' => 'string',
        'is_active' => 'boolean',
        'price' => 'number',
        'unit' => 'string',
        'currency' => 'string',
        'style' => 'string',
        'type' => 'string',
        'sort_order' => 'integer',
        'multiple_bookings_allowed' => 'boolean',
        'multiple_bookings_bypassed' => 'boolean',
        'multiple_bookings_allocation' => 'integer',
        'early_booking_limit' => 'integer',
        'late_booking_limit' => 'integer',
        'late_cancellation_limit' => 'integer',
        'maximum_booking_length' => 'integer',
        'minimum_booking_length' => 'integer',
        'booking_interval_limit' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * {@inheritdoc}
     */
    public $translatable = [
        'name',
        'description',
    ];

    /**
     * {@inheritdoc}
     */
    public $sortable = [
        'order_column_name' => 'sort_order',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

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
    protected static $logAttributes = [
        'slug',
        'name',
        'description',
        'is_active',
        'price',
        'unit',
        'currency',
        'style',
        'type',
        'sort_order',
        'multiple_bookings_allowed',
        'multiple_bookings_bypassed',
        'multiple_bookings_allocation',
        'early_booking_limit',
        'late_booking_limit',
        'late_cancellation_limit',
        'maximum_booking_length',
        'minimum_booking_length',
        'booking_interval_limit',
    ];

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

        $this->setTable(config('cortex.bookings.tables.resources'));
        $this->setRules([
            'slug' => 'required|alpha_dash|max:150|unique:'.config('cortex.bookings.tables.resources').',slug',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:10000',
            'is_active' => 'sometimes|boolean',
            'price' => 'required|numeric',
            'unit' => 'required|string|in:m,h,d',
            'currency' => 'required|string|size:3',
            'style' => 'nullable|string|max:150',
            'type' => 'nullable|string|max:150',
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

    /**
     * Get the active resources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    /**
     * Get the inactive resources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive(Builder $builder): Builder
    {
        return $builder->where('is_active', false);
    }

    /**
     * Get the options for generating the slug.
     *
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->doNotGenerateSlugsOnUpdate()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug');
    }

    /**
     * Activate the resource.
     *
     * @return $this
     */
    public function activate()
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the resource.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);

        return $this;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

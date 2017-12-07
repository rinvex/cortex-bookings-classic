<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Spatie\Sluggable\SlugOptions;
use Rinvex\Support\Traits\HasSlug;
use Rinvex\Tenants\Traits\Tenantable;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Rinvex\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\HasTranslations;
use Rinvex\Support\Traits\ValidatingTrait;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Bookings\Traits\Bookable as BookableTrait;

abstract class Bookable extends Model implements Sortable
{
    use HasSlug;
    use Tenantable;
    use LogsActivity;
    use BookableTrait;
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

<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Rinvex\Tags\Traits\Taggable;
use Spatie\MediaLibrary\HasMedia;
use Rinvex\Bookings\Models\Bookable;
use Rinvex\Tenants\Traits\Tenantable;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Cortex\Foundation\Traits\FiresCustomModelEvent;
use Cortex\Foundation\Events\ModelDeleted;
use Cortex\Foundation\Events\ModelCreated;
use Cortex\Foundation\Events\ModelUpdated;
use Cortex\Foundation\Events\ModelRestored;

class Service extends Bookable implements HasMedia
{
    use Taggable;
    use Auditable;
    use Tenantable;
    use HashidsTrait;
    use LogsActivity;
    use InteractsWithMedia;
    use FiresCustomModelEvent;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
        'deleted' => ModelDeleted::class,
        'restored' => ModelRestored::class,
        'updated' => ModelUpdated::class,
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'slug' => 'required|alpha_dash|max:150',
        'name' => 'required|string|strip_tags|max:150',
        'description' => 'nullable|string|max:10000',
        'is_active' => 'sometimes|boolean',
        'base_cost' => 'nullable|numeric',
        'unit_cost' => 'required|numeric',
        'currency' => 'required|string|size:3',
        'unit' => 'required|in:minute,hour,day,month',
        'maximum_units' => 'nullable|integer|max:10000',
        'minimum_units' => 'nullable|integer|max:10000',
        'is_cancelable' => 'nullable|boolean',
        'is_recurring' => 'nullable|boolean',
        'sort_order' => 'nullable|integer|max:10000',
        'capacity' => 'nullable|integer|max:10000',
        'style' => 'nullable|string|strip_tags|max:150',
        'tags' => 'nullable|array',
    ];

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

        $this->setTable(config('cortex.bookings.tables.services'));
    }

    /**
     * {@inheritdoc}
     */
    public static function getBookingModel(): string
    {
        return config('cortex.bookings.models.service_booking');
    }

    /**
     * {@inheritdoc}
     */
    public static function getRateModel(): string
    {
        return config('cortex.bookings.models.service_rate');
    }

    /**
     * {@inheritdoc}
     */
    public static function getAvailabilityModel(): string
    {
        return config('cortex.bookings.models.service_availability');
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
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

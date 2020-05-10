<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Rinvex\Tags\Traits\Taggable;
use Spatie\MediaLibrary\HasMedia;
use Rinvex\Tenants\Traits\Tenantable;
use Rinvex\Bookings\Models\Ticketable;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Ticketable implements HasMedia
{
    use Taggable;
    use Auditable;
    use Tenantable;
    use HashidsTrait;
    use LogsActivity;
    use InteractsWithMedia;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_public',
        'starts_at',
        'ends_at',
        'timezone',
        'location',
        'tags',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'slug' => 'string',
        'name' => 'string',
        'description' => 'string',
        'is_public' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'timezone' => 'string',
        'location' => 'string',
        'deleted_at' => 'datetime',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'slug' => 'required|alpha_dash|max:150',
        'name' => 'required|string|strip_tags|max:150',
        'description' => 'nullable|string|strip_tags|max:10000',
        'is_public' => 'sometimes|boolean',
        'starts_at' => 'required|string|max:150',
        'ends_at' => 'required|string|max:150',
        'timezone' => 'required|string|max:150|timezone',
        'location' => 'nullable|string|max:150',
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

        $this->setTable(config('cortex.bookings.tables.events'));
    }

    /**
     * Get the booking model name.
     *
     * @return string
     */
    public function getBookingModel(): string
    {
        return config('cortex.bookings.models.event_booking');
    }

    /**
     * Get the ticket model name.
     *
     * @return string
     */
    public function getTicketModel(): string
    {
        return config('cortex.bookings.models.event_ticket');
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
}

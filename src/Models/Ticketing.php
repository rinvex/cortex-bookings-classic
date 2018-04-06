<?php

declare(strict_types=1);

namespace Cortex\Bookings\Models;

use Spatie\Sluggable\SlugOptions;
use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\ValidatingTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticketing extends Model implements Sortable
{
    use Auditable;
    use LogsActivity;
    use ValidatingTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'event_id',
        'slug',
        'name',
        'description',
        'is_active',
        'price',
        'currency',
        'quantity',
        'sort_order',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'event_id' => 'integer',
        'slug' => 'string',
        'name' => 'string',
        'description' => 'string',
        'is_active' => 'boolean',
        'price' => 'float',
        'currency' => 'string',
        'quantity' => 'integer',
        'sort_order' => 'integer',
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

        $this->setTable(config('cortex.bookings.tables.tickets'));
        $this->setRules([
            'event_id' => 'required|integer|exists:'.config('cortex.bookings.tables.events').',id',
            'slug' => 'required|alpha_dash|max:150|unique:'.config('cortex.bookings.tables.tickets').',slug,NULL,id,event_id,'.($this->event_id ?? 'null'),
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:10000',
            'is_active' => 'sometimes|boolean',
            'price' => 'required|numeric',
            'currency' => 'required|alpha|size:3',
            'quantity' => 'nullable|integer|max:10000000',
            'sort_order' => 'nullable|integer|max:10000000',
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
    public function makeActive()
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the resource.
     *
     * @return $this
     */
    public function makeInactive()
    {
        $this->update(['is_active' => false]);

        return $this;
    }

    /**
     * Relationship to the event.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}

<?php

declare(strict_types=1);

namespace Cortex\Bookings\DataTables\Adminarea;

use Cortex\Bookings\Models\Event;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Bookings\Transformers\Adminarea\EventTransformer;

class EventsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Event::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = EventTransformer::class;

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.events.edit\', {event: full.id, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.events.edit\', {event: full.id})+"\">"+data+"</a>"';

        return [
            'name' => ['title' => trans('cortex/bookings::common.name'), 'render' => $link.'+(full.is_public ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'starts_at' => ['title' => trans('cortex/bookings::common.starts_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'ends_at' => ['title' => trans('cortex/bookings::common.ends_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'timezone' => ['title' => trans('cortex/bookings::common.timezone')],
            'created_at' => ['title' => trans('cortex/bookings::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/bookings::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}

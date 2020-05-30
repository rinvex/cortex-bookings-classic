<?php

declare(strict_types=1);

namespace Cortex\Bookings\DataTables\Adminarea;

use Cortex\Bookings\Models\Event;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Bookings\Transformers\Adminarea\EventTransformer;

class TicketingDataTable extends AbstractDataTable
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
            'id' => ['checkboxes' => '{"selectRow": true}', 'exportable' => false, 'printable' => false],
            'name' => ['title' => trans('cortex/bookings::common.name'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'price' => ['title' => trans('cortex/bookings::common.price'), 'render' => 'Lang.trans(\'cortex/bookings::common.unit_\'+data)'],
            'currency' => ['title' => trans('cortex/bookings::common.currency')],
            'capacity' => ['title' => trans('cortex/bookings::common.capacity'), 'orderable' => false, 'searchable' => false],
            'created_at' => ['title' => trans('cortex/bookings::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/bookings::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}

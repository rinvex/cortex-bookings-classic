<?php

declare(strict_types=1);

namespace Cortex\Bookings\DataTables\Adminarea;

use Cortex\Bookings\Models\ServiceBooking;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Bookings\Transformers\Adminarea\ServiceBookingTransformer;

class ServiceBookingsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = ServiceBooking::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = ServiceBookingTransformer::class;

    /**
     * {@inheritdoc}
     */
    protected $order = [
        [0, 'asc'],
        [5, 'asc'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $builderParameters = [
        'rowGroup' => '{
            dataSrc: \'group\'
        }',
    ];

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.services.edit\', {service: full.id, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.services.edit\', {service: full.id})+"\">"+data+"</a>"';

        return [
            'name' => ['title' => trans('cortex/bookings::common.name'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'base_cost' => ['title' => trans('cortex/bookings::common.base_cost')],
            'unit_cost' => ['title' => trans('cortex/bookings::common.unit_cost')],
            'unit' => ['title' => trans('cortex/bookings::common.unit'), 'render' => 'Lang.trans(\'cortex/bookings::common.unit_\'+data)'],
            'currency' => ['title' => trans('cortex/bookings::common.currency')],
            'sort_order' => ['title' => trans('cortex/bookings::common.sort_order'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/bookings::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/bookings::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}

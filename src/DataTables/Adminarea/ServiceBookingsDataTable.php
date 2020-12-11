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
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables($this->query())
            ->setTransformer(app($this->transformer))
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'adminarea.cortex.auth.members.edit\', {member: full.customer.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+full.customer.username+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.cortex.auth.members.edit\', {member: full.customer.id})+"\">"+full.customer.username+"</a>"';

        return [
            'id' => ['checkboxes' => '{"selectRow": true}', 'exportable' => false, 'printable' => false],
            'customer' => ['title' => trans('cortex/bookings::common.customer'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'price' => ['title' => trans('cortex/bookings::common.price')],
            'quantity' => ['title' => trans('cortex/bookings::common.quantity')],
            'total_paid' => ['title' => trans('cortex/bookings::common.total_paid')],
            'currency' => ['title' => trans('cortex/bookings::common.currency')],
            'starts_at' => ['title' => trans('cortex/bookings::common.starts_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'ends_at' => ['title' => trans('cortex/bookings::common.ends_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'created_at' => ['title' => trans('cortex/bookings::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/bookings::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}

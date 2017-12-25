<?php

declare(strict_types=1);

namespace Cortex\Bookings\DataTables\Managerarea;

use Cortex\Bookings\Contracts\RoomContract;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Bookings\Transformers\Managerarea\RoomTransformer;

class RoomsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = RoomContract::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = RoomTransformer::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $locale = app()->getLocale();
        $query = app($this->model)->query()->orderBy('sort_order', 'ASC')->orderBy("name->\${$locale}", 'ASC');

        return $this->applyScopes($query);
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        $transformer = app($this->transformer);

        return datatables()->eloquent($this->query())
                           ->setTransformer($transformer)
                           ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
                           ->make(true);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'managerarea.rooms.edit\', {room: full.slug, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'managerarea.rooms.edit\', {room: full.slug})+"\">"+data+"</a>"';

        return [
            'name' => ['title' => trans('cortex/bookings::common.name'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'price' => ['title' => trans('cortex/bookings::common.price')],
            'unit' => ['title' => trans('cortex/bookings::common.unit')],
            'currency' => ['title' => trans('cortex/bookings::common.currency')],
            'sort_order' => ['title' => trans('cortex/bookings::common.sort_order'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/bookings::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/bookings::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}

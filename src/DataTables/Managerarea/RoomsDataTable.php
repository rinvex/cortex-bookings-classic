<?php

declare(strict_types=1);

namespace Cortex\Bookings\DataTables\Managerarea;

use Cortex\Bookings\Models\Room;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Bookings\Transformers\Managerarea\RoomTransformer;

class RoomsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Room::class;

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
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        $link = config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'managerarea.rooms.edit\', {room: full.id, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'managerarea.rooms.edit\', {room: full.id})+"\">"+data+"</a>"';

        return [
            'name' => ['title' => trans('cortex/bookings::common.name'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
            'base_cost' => ['title' => trans('cortex/bookings::common.base_cost')],
            'unit_cost' => ['title' => trans('cortex/bookings::common.unit_cost')],
            'unit' => ['title' => trans('cortex/bookings::common.unit'), 'render' => 'Lang.trans(\'cortex/bookings::common.unit_\'+data)'],
            'currency' => ['title' => trans('cortex/bookings::common.currency')],
            'sort_order' => ['title' => trans('cortex/bookings::common.sort_order'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/bookings::common.created_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
            'updated_at' => ['title' => trans('cortex/bookings::common.updated_at'), 'render' => "moment(data).format('MMM Do, YYYY')"],
        ];
    }
}

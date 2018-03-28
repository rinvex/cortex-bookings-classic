<?php

declare(strict_types=1);

namespace Cortex\Bookings\DataTables\Managerarea;

use Cortex\Bookings\Models\Event;
use Cortex\Foundation\DataTables\AbstractDataTable;

class EventsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Event::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $locale = app()->getLocale();
        $query = app($this->model)->query()->orderBy('sort_order', 'ASC')->orderBy("title->\${$locale}", 'ASC');

        return $this->applyScopes($query);
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables($this->query())
            ->orderColumn('title', 'title->"$.'.app()->getLocale().'" $1')
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
            ? '"<a href=\""+routes.route(\'managerarea.events.edit\', {event: full.name, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'managerarea.events.edit\', {event: full.name})+"\">"+data+"</a>"';

        return [
            'title' => ['title' => trans('cortex/bookings::common.title'), 'render' => $link.'+(full.is_active ? " <i class=\"text-success fa fa-check\"></i>" : " <i class=\"text-danger fa fa-close\"></i>")', 'responsivePriority' => 0],
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

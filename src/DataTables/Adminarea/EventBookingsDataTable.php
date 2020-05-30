<?php

declare(strict_types=1);

namespace Cortex\Bookings\DataTables\Adminarea;

use Cortex\Bookings\Models\EventBooking;
use Illuminate\Database\Eloquent\Builder;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\Contacts\DataTables\Adminarea\ContactsDataTable;

class EventBookingsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = EventBooking::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = ContactsDataTable::class;

    /**
     * Get the query object to be processed by dataTables.
     *
     * @TODO: Apply row selection and bulk actions, check parent::query() for reference.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $custoemrs = $this->resource->tickets()->with(['bookings'])->get()->pluck('bookings')->collapse()->pluck('customer_id');

        return app('rinvex.contacts.contact')->whereIn('id', $custoemrs);
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables($this->query())
            //->setTransformer(app($this->transformer))
            ->filterColumn('country_code', function (Builder $builder, $keyword) {
                $countryCode = collect(countries())->search(function ($country) use ($keyword) {
                    return mb_strpos($country['name'], $keyword) !== false || mb_strpos($country['emoji'], $keyword) !== false;
                });

                ! $countryCode || $builder->where('country_code', $countryCode);
            })
            ->filterColumn('language_code', function (Builder $builder, $keyword) {
                $languageCode = collect(languages())->search(function ($language) use ($keyword) {
                    return mb_strpos($language['name'], $keyword) !== false;
                });

                ! $languageCode || $builder->where('language_code', $languageCode);
            })
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
            ? '"<a href=\""+routes.route(\'adminarea.contacts.edit\', {contact: full.id, locale: \''.$this->request->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'adminarea.contacts.edit\', {contact: full.id})+"\">"+data+"</a>"';

        return [
            'id' => ['checkboxes' => '{"selectRow": true}', 'exportable' => false, 'printable' => false],
            'given_name' => ['title' => trans('cortex/contacts::common.given_name'), 'render' => $link, 'responsivePriority' => 0],
            'family_name' => ['title' => trans('cortex/contacts::common.family_name')],
            'email' => ['title' => trans('cortex/contacts::common.email')],
            'phone' => ['title' => trans('cortex/contacts::common.phone')],
            'country_code' => ['title' => trans('cortex/contacts::common.country'), 'render' => 'full.country_emoji+" "+data'],
            'language_code' => ['title' => trans('cortex/contacts::common.language'), 'visible' => false],
            'source' => ['title' => trans('cortex/contacts::common.source'), 'visible' => false],
            'method' => ['title' => trans('cortex/contacts::common.method'), 'visible' => false],
            'created_at' => ['title' => trans('cortex/contacts::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/contacts::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }
}

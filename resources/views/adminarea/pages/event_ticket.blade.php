{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Bookings\Http\Requests\Adminarea\EventTicketFormRequest::class)->selector("#adminarea-cortex-bookings-events-tickets-create-form, #adminarea-cortex-bookings-events-{$event->getRouteKey()}-tickets-{$eventTicket->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @includeWhen($event->exists, 'cortex/foundation::common.partials.modal', ['id' => 'delete-confirmation'])

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @if($eventTicket->exists && (app('request.user')->can('delete', $eventTicket) || app('request.user')->can('create', $eventTicket)))
                    <div class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                           data-modal-action="{{ route('adminarea.events.tickets.destroy', ['event' => $event, 'ticket' => $eventTicket]) }}"
                           data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                           data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                           data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/bookings::common.event_ticket'), 'identifier' => $eventTicket->getRouteKey()]) }}"
                           title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>
                @endif
                {!! Menu::render('adminarea.events.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($eventTicket->exists)
                            {{ Form::model($eventTicket, ['url' => route('adminarea.events.tickets.update', ['event' => $event, 'ticket' => $eventTicket]), 'method' => 'put', 'id' => "adminarea-cortex-bookings-events-{$event->getRouteKey()}-tickets-{$eventTicket->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($eventTicket, ['url' => route('adminarea.events.tickets.store', ['event' => $event]), 'id' => 'adminarea-cortex-bookings-events-tickets-create-form']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/bookings::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.name'), 'data-slugify' => '[name="slug"]', 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Slug --}}
                                    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                                        {{ Form::label('slug', trans('cortex/bookings::common.slug'), ['class' => 'control-label']) }}
                                        {{ Form::text('slug', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.slug'), 'required' => 'required']) }}

                                        @if ($errors->has('slug'))
                                            <span class="help-block">{{ $errors->first('slug') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Is Active --}}
                                    <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                        {{ Form::label('is_active', trans('cortex/bookings::common.is_active'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_active', [1 => trans('cortex/bookings::common.yes'), 0 => trans('cortex/bookings::common.no')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                        @if ($errors->has('is_active'))
                                            <span class="help-block">{{ $errors->first('is_active') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Price --}}
                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                        {{ Form::label('price', trans('cortex/bookings::common.price'), ['class' => 'control-label']) }}
                                        {{ Form::number('price', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.price'), 'required' => 'required']) }}

                                        @if ($errors->has('price'))
                                            <span class="help-block">{{ $errors->first('price') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Currency --}}
                                    <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
                                        {{ Form::label('currency', trans('cortex/bookings::common.currency'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('currency', '', ['class' => 'skip-validation', 'id' => 'currency_hidden']) }}
                                        {{ Form::select('currency', currencies(), null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/bookings::common.select_currency'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('currency'))
                                            <span class="help-block">{{ $errors->first('currency') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Quantity --}}
                                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                                        {{ Form::label('quantity', trans('cortex/bookings::common.quantity'), ['class' => 'control-label']) }}
                                        {{ Form::number('quantity', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.quantity')]) }}

                                        @if ($errors->has('quantity'))
                                            <span class="help-block">{{ $errors->first('quantity') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Description --}}
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        {{ Form::label('description', trans('cortex/bookings::common.description'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control tinymce', 'placeholder' => trans('cortex/bookings::common.description'), 'rows' => 5]) }}

                                        @if ($errors->has('description'))
                                            <span class="help-block">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/bookings::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::common.partials.timestamps', ['model' => $eventTicket])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

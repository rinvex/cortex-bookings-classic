{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Bookings\Http\Requests\Adminarea\EventBookingFormRequest::class)->selector("#adminarea-events-bookings-create-form, #adminarea-events-{$event->getRouteKey()}-bookings-{$eventBooking->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
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
                @if($eventBooking->exists && app('request.user')->can('delete', $eventBooking))
                    <div class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                           data-modal-action="{{ route('adminarea.events.bookings.destroy', ['event' => $event, 'booking' => $eventBooking]) }}"
                           data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                           data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                           data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/bookings::common.event_booking'), 'identifier' => $eventBooking->getRouteKey()]) }}"
                           title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>
                @endif
                {!! Menu::render('adminarea.events.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($eventBooking->exists)
                            {{ Form::model($eventBooking, ['url' => route('adminarea.events.bookings.update', ['event' => $event, 'booking' => $eventBooking]), 'method' => 'put', 'id' => "adminarea-events-{$event->getRouteKey()}-bookings-{$eventBooking->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($eventBooking, ['url' => route('adminarea.events.bookings.store', ['event' => $event]), 'id' => 'adminarea-events-bookings-create-form']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Customer --}}
                                    <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
                                        {{ Form::label('customer_id', trans('cortex/bookings::common.customer'), ['class' => 'control-label']) }}
                                        {{ Form::select('customer_id', $customers, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/bookings::common.select_customer'), 'required' => 'required', 'data-width' => '100%']) }}

                                        @if ($errors->has('customer_id'))
                                            <span class="help-block">{{ $errors->first('customer_id') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Ticket --}}
                                    <div class="form-group{{ $errors->has('ticket_id') ? ' has-error' : '' }}">
                                        {{ Form::label('ticket_id', trans('cortex/bookings::common.ticket'), ['class' => 'control-label']) }}
                                        {{ Form::select('ticket_id', $tickets, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/bookings::common.select_ticket'), 'required' => 'required', 'data-width' => '100%']) }}

                                        @if ($errors->has('ticket_id'))
                                            <span class="help-block">{{ $errors->first('ticket_id') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-3">

                                    {{-- Paid --}}
                                    <div class="form-group{{ $errors->has('paid') ? ' has-error' : '' }}">
                                        {{ Form::label('paid', trans('cortex/bookings::common.paid'), ['class' => 'control-label']) }}
                                        {{ Form::number('paid', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.paid'), 'required' => 'required']) }}

                                        @if ($errors->has('paid'))
                                            <span class="help-block">{{ $errors->first('paid') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-1">

                                    {{-- Currency --}}
                                    <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
                                        {{ Form::label('currency', trans('cortex/bookings::common.currency'), ['class' => 'control-label']) }}
                                        {{ Form::text('currency', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.currency'), 'required' => 'required']) }}

                                        @if ($errors->has('currency'))
                                            <span class="help-block">{{ $errors->first('currency') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Approved --}}
                                    <div class="form-group{{ $errors->has('is_approved') ? ' has-error' : '' }}">
                                        {{ Form::label('is_approved', trans('cortex/bookings::common.is_approved'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_approved', [1 => trans('cortex/bookings::common.yes'), 0 => trans('cortex/bookings::common.no')], null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/bookings::common.is_approved'), 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('is_approved'))
                                            <span class="help-block">{{ $errors->first('is_approved') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Confirmed --}}
                                    <div class="form-group{{ $errors->has('is_confirmed') ? ' has-error' : '' }}">
                                        {{ Form::label('is_confirmed', trans('cortex/bookings::common.is_confirmed'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_confirmed', [1 => trans('cortex/bookings::common.yes'), 0 => trans('cortex/bookings::common.no')], null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/bookings::common.is_confirmed'), 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('is_confirmed'))
                                            <span class="help-block">{{ $errors->first('is_confirmed') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Attended --}}
                                    <div class="form-group{{ $errors->has('is_attended') ? ' has-error' : '' }}">
                                        {{ Form::label('is_attended', trans('cortex/bookings::common.is_attended'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_attended', [1 => trans('cortex/bookings::common.yes'), 0 => trans('cortex/bookings::common.no')], null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/bookings::common.is_attended'), 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('is_attended'))
                                            <span class="help-block">{{ $errors->first('is_attended') }}</span>
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

                                    @include('cortex/foundation::adminarea.partials.timestamps', ['model' => $eventBooking])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

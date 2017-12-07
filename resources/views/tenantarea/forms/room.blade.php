{{-- Master Layout --}}
@extends('cortex/foundation::tenantarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.tenantarea') }} » {{ trans('cortex/bookings::common.rooms') }} » {{ $room->exists ? $room->name : trans('cortex/bookings::common.create_room') }}
@stop

@push('scripts')
    {!! JsValidator::formRequest(Cortex\Bookings\Http\Requests\Tenantarea\RoomFormRequest::class)->selector('#tenantarea-bookings-rooms-save') !!}
@endpush

{{-- Main Content --}}
@section('content')

    @if($room->exists)
        @include('cortex/foundation::common.partials.confirm-deletion', ['type' => 'room'])
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ $room->exists ? $room->name : trans('cortex/bookings::common.create_room') }}</h1>
            <!-- Breadcrumbs -->
            {{ Breadcrumbs::render() }}
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details-tab" data-toggle="tab">{{ trans('cortex/bookings::common.details') }}</a></li>
                    @if($room->exists) <li><a href="{{ route('tenantarea.rooms.logs', ['room' => $room]) }}">{{ trans('cortex/bookings::common.logs') }}</a></li> @endif
                    @if($room->exists && $currentUser->can('delete-rooms', $room)) <li class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-item-href="{{ route('tenantarea.rooms.delete', ['room' => $room]) }}" data-item-name="{{ $room->slug }}"><i class="fa fa-trash text-danger"></i></a></li> @endif
                </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($room->exists)
                            {{ Form::model($room, ['url' => route('tenantarea.rooms.update', ['room' => $room]), 'method' => 'put', 'id' => 'tenantarea-bookings-rooms-save']) }}
                        @else
                            {{ Form::model($room, ['url' => route('tenantarea.rooms.store'), 'id' => 'tenantarea-bookings-rooms-save']) }}
                        @endif

                            <div class="row">

                                <div class="col-md-8">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/bookings::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.name'), 'data-slugify' => '#slug', 'required' => 'required', 'autofocus' => 'autofocus']) }}

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

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Sort Order --}}
                                    <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
                                        {{ Form::label('sort_order', trans('cortex/bookings::common.sort_order'), ['class' => 'control-label']) }}
                                        {{ Form::number('sort_order', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.sort_order')]) }}

                                        @if ($errors->has('sort_order'))
                                            <span class="help-block">{{ $errors->first('sort_order') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Style --}}
                                    <div class="form-group{{ $errors->has('style') ? ' has-error' : '' }}">
                                        {{ Form::label('style', trans('cortex/tags::common.style'), ['class' => 'control-label']) }}
                                        {{ Form::text('style', null, ['class' => 'form-control style-picker', 'placeholder' => trans('cortex/tags::common.style'), 'data-placement' => 'bottomRight', 'readonly' => 'readonly']) }}

                                        @if ($errors->has('style'))
                                            <span class="help-block">{{ $errors->first('style') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Active --}}
                                    <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                        {{ Form::label('is_active', trans('cortex/fort::common.active'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_active', [1 => trans('cortex/fort::common.yes'), 0 => trans('cortex/fort::common.no')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

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

                                    {{-- Unit --}}
                                    <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}">
                                        {{ Form::label('unit', trans('cortex/bookings::common.unit'), ['class' => 'control-label']) }}
                                        {{ Form::select('unit', ['m' => trans('cortex/bookings::common.unit_m'), 'h' => trans('cortex/bookings::common.unit_h'), 'd' => trans('cortex/bookings::common.unit_d')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%']) }}

                                        @if ($errors->has('unit'))
                                            <span class="help-block">{{ $errors->first('unit') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

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

                                <div class="col-md-12">

                                    {{-- Description --}}
                                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                        {{ Form::label('description', trans('cortex/bookings::common.description'), ['class' => 'control-label']) }}
                                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.description'), 'rows' => 5]) }}

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

                                    @include('cortex/foundation::tenantarea.partials.timestamps', ['model' => $room])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

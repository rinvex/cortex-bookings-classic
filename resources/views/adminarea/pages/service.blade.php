{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('head-elements')
    <meta name="turbolinks-cache-control" content="no-cache">
@endpush

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Bookings\Http\Requests\Adminarea\ServiceFormRequest::class)->selector("#adminarea-cortex-bookings-services-create-form, #adminarea-cortex-bookings-services-{$service->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
    @include('cortex/bookings::adminarea.partials.service-templates')
    @include('cortex/bookings::adminarea.partials.service-scripts')
@endpush

{{-- Main Content --}}
@section('content')

    @includeWhen($service->exists, 'cortex/foundation::common.partials.modal', ['id' => 'delete-confirmation'])

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @includeWhen($service->exists, 'cortex/foundation::common.partials.actions', ['name' => 'service', 'model' => $service, 'resource' => trans('cortex/services::common.service'), 'routePrefix' => 'adminarea.cortex.services.services.'])
                {!! Menu::render('adminarea.services.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($service->exists)
                            {{ Form::model($service, ['url' => route('adminarea.services.update', ['service' => $service]), 'method' => 'put', 'id' => "adminarea-cortex-bookings-services-{$service->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($service, ['url' => route('adminarea.services.store'), 'id' => "adminarea-cortex-bookings-services-create-form"]) }}
                        @endif

                            <div class="box-group" id="accordion">

                                <div class="panel box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseBasics" aria-expanded="true" class="">
                                                {{ trans('cortex/bookings::common.basics') }}
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapseBasics" class="panel-collapse collapse in" aria-expanded="true">

                                        <div class="box-body">

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

                                                    {{-- Base Cost --}}
                                                    <div class="form-group{{ $errors->has('base_cost') ? ' has-error' : '' }}">
                                                        {{ Form::label('base_cost', trans('cortex/bookings::common.base_cost'), ['class' => 'control-label']) }}
                                                        {{ Form::number('base_cost', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.base_cost')]) }}

                                                        @if ($errors->has('base_cost'))
                                                            <span class="help-block">{{ $errors->first('base_cost') }}</span>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="col-md-4">

                                                    {{-- Unit Cost --}}
                                                    <div class="form-group{{ $errors->has('unit_cost') ? ' has-error' : '' }}">
                                                        {{ Form::label('unit_cost', trans('cortex/bookings::common.unit_cost'), ['class' => 'control-label']) }}
                                                        {{ Form::number('unit_cost', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.unit_cost'), 'required' => 'required']) }}

                                                        @if ($errors->has('unit_cost'))
                                                            <span class="help-block">{{ $errors->first('unit_cost') }}</span>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="col-md-4">

                                                    {{-- Unit --}}
                                                    <div class="form-group{{ $errors->has('unit') ? ' has-error' : '' }}">
                                                        {{ Form::label('unit', trans('cortex/bookings::common.unit'), ['class' => 'control-label']) }}
                                                        {{ Form::select('unit', ['use' => trans('cortex/bookings::common.unit_use'), 'minute' => trans('cortex/bookings::common.unit_minute'), 'hour' => trans('cortex/bookings::common.unit_hour'), 'day' => trans('cortex/bookings::common.unit_day'), 'month' => trans('cortex/bookings::common.unit_month')], $service->exists ? null : 'hour', ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                                        @if ($errors->has('unit'))
                                                            <span class="help-block">{{ $errors->first('unit') }}</span>
                                                        @endif
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="row">

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

                                            </div>

                                            <div class="row">

                                                <div class="col-md-12">

                                                    {{-- Tags --}}
                                                    <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                                                        {{ Form::label('tags[]', trans('cortex/bookings::common.tags'), ['class' => 'control-label']) }}
                                                        {{ Form::hidden('tags', '', ['class' => 'skip-validation']) }}
                                                        {{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2', 'multiple' => 'multiple', 'data-width' => '100%', 'data-tags' => 'true']) }}

                                                        @if ($errors->has('tags'))
                                                            <span class="help-block">{{ $errors->first('tags') }}</span>
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

                                        </div>

                                    </div>

                                </div>

                                <div class="panel box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseRates" class="collapsed" aria-expanded="false">
                                                {{ trans('cortex/bookings::common.rates') }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseRates" class="panel-collapse collapse" aria-expanded="false">
                                        <div class="box-body">

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <button class="btn btn-primary" id="rateBtn" data-template="rate" data-container="rates-container" type="button"><i class="fa fa-plus"></i> {{ trans('cortex/bookings::common.add_rate') }}</button>

                                                </div>

                                            </div>

                                            <hr />

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div id="rates-container"></div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="panel box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseAvailabilities" class="collapsed" aria-expanded="false">
                                                {{ trans('cortex/bookings::common.availabilities') }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseAvailabilities" class="panel-collapse collapse" aria-expanded="false">
                                        <div class="box-body">

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <button class="btn btn-primary" id="availabilityBtn" data-template="availability" data-container="availabilities-container" type="button"><i class="fa fa-plus"></i> @lang('cortex/bookings::common.add_availability')</button>

                                                </div>

                                            </div>

                                            <hr />

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div id="availabilities-container"></div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/bookings::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit', 'id' => 'service-submit-button']) }}
                                    </div>

                                    @include('cortex/foundation::common.partials.timestamps', ['model' => $service])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

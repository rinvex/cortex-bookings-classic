{{-- Master Layout --}}
@extends('cortex/foundation::adminarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ extract_title(Breadcrumbs::render()) }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Bookings\Http\Requests\Adminarea\EventFormRequest::class)->selector("#adminarea-events-create-form, #adminarea-events-{$event->getRouteKey()}-update-form")->ignore('.skip-validation') !!}
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
                @if($event->exists && app('request.user')->can('delete', $event))
                    <div class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                           data-modal-action="{{ route('adminarea.events.destroy', ['event' => $event]) }}"
                           data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                           data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                           data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/bookings::common.event'), 'identifier' => $event->getRouteKey()]) }}"
                           title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i>
                        </a>
                    </div>
                @endif
                {!! Menu::render('adminarea.events.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($event->exists)
                            {{ Form::model($event, ['url' => route('adminarea.events.update', ['event' => $event]), 'method' => 'put', 'id' => "adminarea-events-{$event->getRouteKey()}-update-form"]) }}
                        @else
                            {{ Form::model($event, ['url' => route('adminarea.events.store'), 'id' => "adminarea-events-create-form"]) }}
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

                                    {{-- Is Public --}}
                                    <div class="form-group{{ $errors->has('is_public') ? ' has-error' : '' }}">
                                        {{ Form::label('is_public', trans('cortex/bookings::common.is_public'), ['class' => 'control-label']) }}
                                        {{ Form::select('is_public', [1 => trans('cortex/bookings::common.yes'), 0 => trans('cortex/bookings::common.no')], null, ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

                                        @if ($errors->has('is_public'))
                                            <span class="help-block">{{ $errors->first('is_public') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Duration --}}
                                    <div class="form-group has-feedback{{ $errors->has('duration') ? ' has-error' : '' }}">
                                        {{ Form::label('duration', trans('cortex/bookings::common.duration'), ['class' => 'control-label']) }}
                                        {{ Form::text('duration', null, ['class' => 'form-control datepicker', 'data-locale' => '{"format": "YYYY-MM-DD, hh:mm A"}', 'data-single-date-picker' => 'false', 'data-show-dropdowns' => 'true', 'data-time-picker' => 'true', 'data-time-picker-increment' => '10', 'data-auto-apply' => 'true']) }}
                                        <span class="fa fa-calendar form-control-feedback"></span>

                                        @if ($errors->has('duration'))
                                            <span class="help-block">{{ $errors->first('duration') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Timezone --}}
                                    <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
                                        {{ Form::label('timezone', trans('cortex/bookings::common.timezone'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('timezone', '', ['class' => 'skip-validation', 'id' => 'timezone_hidden']) }}
                                        {{ Form::select('timezone', timezones(), null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/bookings::common.select_timezone'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                        @if ($errors->has('timezone'))
                                            <span class="help-block">{{ $errors->first('timezone') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Location --}}
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        {{ Form::label('location', trans('cortex/bookings::common.location'), ['class' => 'control-label']) }}
                                        {{ Form::text('location', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.location')]) }}

                                        @if ($errors->has('location'))
                                            <span class="help-block">{{ $errors->first('location') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Profile Picture --}}
                                    <div class="form-group has-feedback{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                                        {{ Form::label('profile_picture', trans('cortex/bookings::common.profile_picture'), ['class' => 'control-label']) }}

                                        <div class="input-group">
                                            {{ Form::text('profile_picture', null, ['class' => 'form-control file-name', 'placeholder' => trans('cortex/bookings::common.profile_picture'), 'readonly' => 'readonly']) }}

                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    {{ trans('cortex/bookings::common.browse') }}
                                                    {{-- Skip Javascrip validation for file input fields to avoid size validation conflict with jquery.validator --}}
                                                    {{ Form::file('profile_picture', ['class' => 'form-control skip-validation', 'id' => 'profile_picture_browse']) }}
                                                </span>
                                            </span>
                                        </div>

                                        @if ($event->exists && $event->getMedia('profile_picture')->count())
                                            <i class="fa fa-paperclip"></i>
                                            <a href="{{ $event->getFirstMediaUrl('profile_picture') }}" target="_blank">{{ $event->getFirstMedia('profile_picture')->file_name }}</a> ({{ $event->getFirstMedia('profile_picture')->human_readable_size }})
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                                               data-modal-action="{{ route('adminarea.events.media.destroy', ['event' => $event, 'media' => $event->getFirstMedia('profile_picture')]) }}"
                                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                                               data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => $event->getFirstMedia('profile_picture')->getRouteKey()]) }}"
                                               title="{{ trans('cortex/foundation::common.delete') }}"><i class="fa fa-trash text-danger"></i></a>
                                        @endif

                                        @if ($errors->has('profile_picture'))
                                            <span class="help-block">{{ $errors->first('profile_picture') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Cover Photo --}}
                                    <div class="form-group has-feedback{{ $errors->has('cover_photo') ? ' has-error' : '' }}">
                                        {{ Form::label('cover_photo', trans('cortex/bookings::common.cover_photo'), ['class' => 'control-label']) }}

                                        <div class="input-group">
                                            {{ Form::text('cover_photo', null, ['class' => 'form-control file-name', 'placeholder' => trans('cortex/bookings::common.cover_photo'), 'readonly' => 'readonly']) }}

                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    {{ trans('cortex/bookings::common.browse') }}
                                                    {{-- Skip Javascrip validation for file input fields to avoid size validation conflict with jquery.validator --}}
                                                    {{ Form::file('cover_photo', ['class' => 'form-control skip-validation', 'id' => 'cover_photo_browse']) }}
                                                </span>
                                            </span>
                                        </div>

                                        @if ($event->exists && $event->getMedia('cover_photo')->count())
                                            <i class="fa fa-paperclip"></i>
                                            <a href="{{ $event->getFirstMediaUrl('cover_photo') }}" target="_blank">{{ $event->getFirstMedia('cover_photo')->file_name }}</a> ({{ $event->getFirstMedia('cover_photo')->human_readable_size }})
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation"
                                               data-modal-action="{{ route('adminarea.events.media.destroy', ['event' => $event, 'media' => $event->getFirstMedia('cover_photo')]) }}"
                                               data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}"
                                               data-modal-button="<a href='#' class='btn btn-danger' data-form='delete' data-token='{{ csrf_token() }}'><i class='fa fa-trash-o'></i> {{ trans('cortex/foundation::common.delete') }}</a>"
                                               data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['resource' => trans('cortex/foundation::common.media'), 'identifier' => $event->getFirstMedia('cover_photo')->getRouteKey()]) }}"
                                               title="{{ trans('cortex/foundation::common.delete') }}"><i class="fa fa-trash text-danger"></i></a>
                                        @endif

                                        @if ($errors->has('cover_photo'))
                                            <span class="help-block">{{ $errors->first('cover_photo') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

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

                            <div class="row">
                                <div class="col-md-12">

                                    <div class="pull-right">
                                        {{ Form::button(trans('cortex/bookings::common.submit'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                    </div>

                                    @include('cortex/foundation::adminarea.partials.timestamps', ['model' => $event])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

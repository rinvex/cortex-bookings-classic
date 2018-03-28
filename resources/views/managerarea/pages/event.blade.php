{{-- Master Layout --}}
@extends('cortex/foundation::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.managerarea') }} » {{ trans('cortex/bookings::common.events') }} » {{ $event->exists ? $event->title : trans('cortex/bookings::common.create_event') }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Bookings\Http\Requests\Managerarea\EventFormRequest::class)->selector("#managerarea-events-create-form, #managerarea-events-{$event->getKey()}-update-form") !!}
@endpush

{{-- Main Content --}}
@section('content')

    @if($event->exists)
        @include('cortex/foundation::common.partials.confirm-deletion')
    @endif

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                @if($event->exists && $currentUser->can('delete', $event)) <div class="pull-right"><a href="#" data-toggle="modal" data-target="#delete-confirmation" data-modal-action="{{ route('managerarea.events.destroy', ['event' => $event]) }}" data-modal-title="{!! trans('cortex/foundation::messages.delete_confirmation_title') !!}" data-modal-body="{!! trans('cortex/foundation::messages.delete_confirmation_body', ['type' => 'event', 'name' => $event->name]) !!}" title="{{ trans('cortex/foundation::common.delete') }}" class="btn btn-default" style="margin: 4px"><i class="fa fa-trash text-danger"></i></a></div> @endif
                {!! Menu::render('managerarea.events.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="details-tab">

                        @if ($event->exists)
                            {{ Form::model($event, ['url' => route('managerarea.events.update', ['event' => $event]), 'method' => 'put', 'id' => "managerarea-events-{$event->getKey()}-update-form"]) }}
                        @else
                            {{ Form::model($event, ['url' => route('managerarea.events.store'), 'id' => "managerarea-events-create-form"]) }}
                        @endif

                            <div class="row">

                                <div class="col-md-4">

                                    {{-- Title --}}
                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                        {{ Form::label('title', trans('cortex/bookings::common.title'), ['class' => 'control-label']) }}
                                        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.title'), 'data-slugify' => '[name="name"]', 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                        @if ($errors->has('title'))
                                            <span class="help-block">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Name --}}
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label('name', trans('cortex/bookings::common.name'), ['class' => 'control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.name'), 'required' => 'required']) }}

                                        @if ($errors->has('name'))
                                            <span class="help-block">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    {{-- Active --}}
                                    <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                        {{ Form::label('is_active', trans('cortex/bookings::common.active'), ['class' => 'control-label']) }}
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
                                        {{ Form::number('base_cost', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.base_cost'), 'required' => 'required']) }}

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
                                        {{ Form::select('unit', ['minute' => trans('cortex/bookings::common.unit_minute'), 'hour' => trans('cortex/bookings::common.unit_hour'), 'day' => trans('cortex/bookings::common.unit_day'), 'month' => trans('cortex/bookings::common.unit_month')], $event->exists ? null : 'day', ['class' => 'form-control select2', 'data-minimum-results-for-search' => 'Infinity', 'data-width' => '100%', 'required' => 'required']) }}

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
                                        {{ Form::text('currency', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.currency'), 'required' => 'required']) }}

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
                                        {{ Form::label('style', trans('cortex/bookings::common.style'), ['class' => 'control-label']) }}
                                        {{ Form::text('style', null, ['class' => 'form-control style-picker', 'placeholder' => trans('cortex/bookings::common.style'), 'data-placement' => 'bottomRight', 'readonly' => 'readonly']) }}

                                        @if ($errors->has('style'))
                                            <span class="help-block">{{ $errors->first('style') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    {{-- Profile Picture --}}
                                    <div class="form-group has-feedback{{ $errors->has('profile_picture') ? ' has-error' : '' }}">
                                        {{ Form::label('profile_picture', trans('cortex/bookings::common.profile_picture'), ['class' => 'control-label']) }}

                                        <div class="input-group">
                                            {{ Form::text('profile_picture', null, ['class' => 'form-control file-name', 'placeholder' => trans('cortex/bookings::common.profile_picture'), 'readonly' => 'readonly']) }}

                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    {{ trans('cortex/bookings::common.browse') }}
                                                    {{ Form::file('profile_picture', ['class' => 'form-control']) }}
                                                </span>
                                            </span>
                                        </div>

                                        @if ($event->exists && $event->getMedia('profile_picture')->count())
                                            <i class="fa fa-paperclip"></i>
                                            <a href="{{ $event->getFirstMediaUrl('profile_picture') }}" target="_blank">{{ $event->getFirstMedia('profile_picture')->file_name }}</a> ({{ $event->getFirstMedia('profile_picture')->human_readable_size }})
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation" data-modal-action="{{ route('managerarea.members.media.destroy', ['member' => $event, 'media' => $event->getFirstMedia('profile_picture')]) }}" data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}" data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['type' => 'media', 'name' => $event->getFirstMedia('profile_picture')->file_name]) }}" title="{{ trans('cortex/foundation::common.delete') }}"><i class="fa fa-trash text-danger"></i></a>
                                        @endif

                                        @if ($errors->has('profile_picture'))
                                            <span class="help-block">{{ $errors->first('profile_picture') }}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    {{-- Cover Photo --}}
                                    <div class="form-group has-feedback{{ $errors->has('cover_photo') ? ' has-error' : '' }}">
                                        {{ Form::label('cover_photo', trans('cortex/bookings::common.cover_photo'), ['class' => 'control-label']) }}

                                        <div class="input-group">
                                            {{ Form::text('cover_photo', null, ['class' => 'form-control file-name', 'placeholder' => trans('cortex/bookings::common.cover_photo'), 'readonly' => 'readonly']) }}

                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    {{ trans('cortex/bookings::common.browse') }}
                                                    {{ Form::file('cover_photo', ['class' => 'form-control']) }}
                                                </span>
                                            </span>
                                        </div>

                                        @if ($event->exists && $event->getMedia('cover_photo')->count())
                                            <i class="fa fa-paperclip"></i>
                                            <a href="{{ $event->getFirstMediaUrl('cover_photo') }}" target="_blank">{{ $event->getFirstMedia('cover_photo')->file_name }}</a> ({{ $event->getFirstMedia('cover_photo')->human_readable_size }})
                                            <a href="#" data-toggle="modal" data-target="#delete-confirmation" data-modal-action="{{ route('managerarea.members.media.destroy', ['member' => $event, 'media' => $event->getFirstMedia('cover_photo')]) }}" data-modal-title="{{ trans('cortex/foundation::messages.delete_confirmation_title') }}" data-modal-body="{{ trans('cortex/foundation::messages.delete_confirmation_body', ['type' => 'media', 'name' => $event->getFirstMedia('cover_photo')->file_name]) }}" title="{{ trans('cortex/foundation::common.delete') }}"><i class="fa fa-trash text-danger"></i></a>
                                        @endif

                                        @if ($errors->has('cover_photo'))
                                            <span class="help-block">{{ $errors->first('cover_photo') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Location --}}
                                    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                        {{ Form::label('location', trans('cortex/bookings::common.location'), ['class' => 'control-label']) }}
                                        {{ Form::text('location', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.location'), 'required' => 'required']) }}

                                        @if ($errors->has('location'))
                                            <span class="help-block">{{ $errors->first('location') }}</span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    {{-- Tags --}}
                                    <div class="form-group{{ $errors->has('tags') ? ' has-error' : '' }}">
                                        {{ Form::label('tags[]', trans('cortex/bookings::common.tags'), ['class' => 'control-label']) }}
                                        {{ Form::hidden('tags', '') }}
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

                                    @include('cortex/foundation::managerarea.partials.timestamps', ['model' => $event])

                                </div>

                            </div>

                        {{ Form::close() }}

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection

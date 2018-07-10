{{-- Availability Action Template --}}
<script type="text/html" id="availability">

    <div class="panel panel-default template-panel">

        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#action-accordion" href="#UNIQUEID">
                    {{ trans('cortex/bookings::common.availability') }}
                </a>
                <button class="btn btn-xs btn-danger pull-right removePanel" data-panel="UNIQUEID" type="button"><i class="fa fa-remove"></i></button>
            </h4>
        </div>

        <div id="UNIQUEID" class="panel-collapse collapse">
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            {{ Form::label('availabilities[UNIQUEID][range]', trans('cortex/bookings::common.range'), ['class' => 'control-label']) }}
                            {{ Form::select('availabilities[UNIQUEID][range]', [], null, ['class' => 'form-control select2', 'id' => 'select-range-UNIQUEID', 'data-width' => '100%', 'required' => 'required']) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('availabilities[UNIQUEID][from]', trans('cortex/bookings::common.from'), ['class' => 'control-label']) }}
                            {{ Form::select('availabilities[UNIQUEID][from]', [], null, ['class' => 'form-control select2', 'disabled' => 'disabled', 'id' => 'select-from-UNIQUEID', 'data-width' => '100%', 'required' => 'required']) }}
                            {{ Form::text('availabilities[UNIQUEID][from]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'date-from-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD"}', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('availabilities[UNIQUEID][from]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'datetime-from-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD, hh:mm A"}', 'data-time-picker' => 'true', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('availabilities[UNIQUEID][from]', null, ['class' => 'form-control timepicker time start', 'style' => 'display: none', 'id' => 'time-from-UNIQUEID', 'data-time-format' => 'H:i A', 'data-show-duration' => 'true']) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('availabilities[UNIQUEID][to]', trans('cortex/bookings::common.to'), ['class' => 'control-label']) }}
                            {{ Form::select('availabilities[UNIQUEID][to]', [], null, ['class' => 'form-control select2', 'disabled' => 'disabled', 'id' => 'select-to-UNIQUEID', 'data-width' => '100%', 'required' => 'required']) }}
                            {{ Form::text('availabilities[UNIQUEID][to]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'date-to-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD"}', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('availabilities[UNIQUEID][to]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'datetime-to-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD, hh:mm A"}', 'data-time-picker' => 'true', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('availabilities[UNIQUEID][to]', null, ['class' => 'form-control timepicker time end', 'style' => 'display: none', 'id' => 'time-to-UNIQUEID', 'data-time-format' => 'H:i A', 'data-show-duration' => 'true']) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('availabilities[UNIQUEID][is_bookable]', trans('cortex/bookings::common.is_bookable'), ['class' => 'control-label']) }}
                            {{ Form::select('availabilities[UNIQUEID][is_bookable]', [0 => trans('cortex/bookings::common.no'), 1 => trans('cortex/bookings::common.yes')], null, ['class' => 'form-control select2', 'data-width' => '100%', 'required' => 'required']) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('availabilities[UNIQUEID][priority]', trans('cortex/bookings::common.priority'), ['class' => 'control-label']) }}
                            {{ Form::number('availabilities[UNIQUEID][priority]', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.priority')]) }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</script>

{{-- Rate Template --}}
<script type="text/html" id="rate">

    <div class="panel panel-default template-panel">

        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#action-accordion" href="#UNIQUEID">
                    {{ trans('cortex/bookings::common.rate') }}
                </a>
                <button class="btn btn-xs btn-danger pull-right removePanel" data-panel="UNIQUEID" type="button"><i class="fa fa-remove"></i></button>
            </h4>
        </div>

        <div id="UNIQUEID" class="panel-collapse collapse">
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            {{ Form::label('rates[UNIQUEID][range]', trans('cortex/bookings::common.range'), ['class' => 'control-label']) }}
                            {{ Form::select('rates[UNIQUEID][range]', [], null, ['class' => 'form-control select2', 'id' => 'select-range-UNIQUEID', 'data-width' => '100%', 'required' => 'required']) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('rates[UNIQUEID][from]', trans('cortex/bookings::common.from'), ['class' => 'control-label']) }}
                            {{ Form::select('rates[UNIQUEID][from]', [], null, ['class' => 'form-control select2', 'disabled' => 'disabled', 'id' => 'select-from-UNIQUEID', 'data-width' => '100%', 'required' => 'required']) }}
                            {{ Form::text('rates[UNIQUEID][from]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'date-from-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD"}', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('rates[UNIQUEID][from]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'datetime-from-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD, hh:mm A"}', 'data-time-picker' => 'true', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('rates[UNIQUEID][from]', null, ['class' => 'form-control timepicker time start', 'style' => 'display: none', 'id' => 'time-from-UNIQUEID', 'data-time-format' => 'H:i A', 'data-show-duration' => 'true']) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('rates[UNIQUEID][to]', trans('cortex/bookings::common.to'), ['class' => 'control-label']) }}
                            {{ Form::select('rates[UNIQUEID][to]', [], null, ['class' => 'form-control select2', 'disabled' => 'disabled', 'id' => 'select-to-UNIQUEID', 'data-width' => '100%', 'required' => 'required']) }}
                            {{ Form::text('rates[UNIQUEID][to]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'date-to-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD"}', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('rates[UNIQUEID][to]', null, ['class' => 'form-control datepicker', 'style' => 'display: none', 'id' => 'datetime-to-UNIQUEID', 'data-locale' => '{"format": "YYYY-MM-DD, hh:mm A"}', 'data-time-picker' => 'true', 'data-single-date-picker' => 'true', 'data-show-dropdowns' => 'true', 'data-auto-apply' => 'true']) }}
                            {{ Form::text('rates[UNIQUEID][to]', null, ['class' => 'form-control timepicker time end', 'style' => 'display: none', 'id' => 'time-to-UNIQUEID', 'data-time-format' => 'H:i A', 'data-show-duration' => 'true']) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('rates[UNIQUEID][base_cost]', trans('cortex/bookings::common.base_cost'), ['class' => 'control-label']) }}
                            {{ Form::number('rates[UNIQUEID][base_cost]', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.base_cost')]) }}

                        </div>

                    </div>

                    <div class="col-md-2">

                        <div class="form-group">

                            {{ Form::label('rates[UNIQUEID][unit_cost]', trans('cortex/bookings::common.unit_cost'), ['class' => 'control-label']) }}
                            {{ Form::number('rates[UNIQUEID][unit_cost]', null, ['class' => 'form-control', 'placeholder' => trans('cortex/bookings::common.unit_cost'), 'required' => 'required']) }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</script>

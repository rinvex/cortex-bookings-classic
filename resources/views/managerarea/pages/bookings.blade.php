{{-- Master Layout --}}
@extends('cortex/tenants::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/foundation::common.managerarea') }} » {{ trans('cortex/bookings::common.bookings') }}
@stop

@push('styles')
    <link href="{{ mix('css/fullcalendar.css', 'assets') }}" rel="stylesheet">
@endpush

@push('scripts-vendor')
    <script src="{{ mix('js/fullcalendar.js', 'assets') }}" type="text/javascript"></script>
    <script src="{{ mix('js/bookings.js', 'assets') }}" type="text/javascript"></script>
@endpush

{{-- Main Content --}}
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-body no-padding">
                            <div data-calendar="bookings"></div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

@endsection

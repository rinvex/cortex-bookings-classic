<script>

    let days = [
        @foreach($days as $index => $day)
            { id: '{{ $index }}', text: '{{ $day }}' },
        @endforeach
    ];

    let weeks = [
        @foreach($weeks as $index => $week)
            { id: '{{ $index }}', text: '{{ $week }}' },
        @endforeach
    ];

    let months = [
        @foreach($months as $index => $month)
            { id: '{{ $index }}', text: '{{ $month }}' },
        @endforeach
    ];

    let ranges = [
        { id: -1, text: "@lang('cortex/bookings::common.select_range')", disabled: true, selected: true },
        @foreach($ranges as $index => $range)
            @if (is_array($range))
                { text: '{{ $index }}', children: [
                @foreach($range as $key => $value)
                    { id: '{{ $key }}', text: '{{ $value }}' },
                @endforeach
            ]},
            @else
                { id: '{{ $index }}', text: '{{ $range }}' },
            @endif
        @endforeach
    ];

    function show_select_menu($panel, data) {
        $panel.find(":text[id^='date-to-']").prop('disabled', true).hide();
        $panel.find(":text[id^='date-from-']").prop('disabled', true).hide();

        $panel.find(":text[id^='datetime-to-']").prop('disabled', true).hide();
        $panel.find(":text[id^='datetime-from-']").prop('disabled', true).hide();

        $panel.find(":text[id^='time-to-']").prop('disabled', true).hide();
        $panel.find(":text[id^='time-from-']").prop('disabled', true).hide();

        $panel.find("select[id^='select-to-']").empty().select2({
            placeholder: 'Select to',
            data: data
        }).prop('disabled', false).show().val({{ $service->to }});

        $panel.find("select[id^='select-from-']").empty().select2({
            placeholder: "Select from",
            data: data,
        }).prop('disabled', false).show().val({{ $service->from }});
    }

    function show_date_field($panel) {
        $panel.find(":text[id^='datetime-to-']").prop('disabled', true).hide().next('.error-help-block').remove();
        $panel.find(":text[id^='datetime-from-']").prop('disabled', true).hide().next('.error-help-block').remove();

        $panel.find("select[id^='select-to-']").prop('disabled', true).next('.select2-container').hide();
        $panel.find("select[id^='select-from-']").prop('disabled', true).next('.select2-container').hide();

        $panel.find(":text[id^='time-to-']").prop('disabled', true).hide();
        $panel.find(":text[id^='time-from-']").prop('disabled', true).hide();

        if ($panel.find(":text[id^='date-to-']").data('daterangepicker')) {
            $panel.find(":text[id^='date-to-']").attr('readonly', true).prop('disabled', false).show();
            $panel.find(":text[id^='date-from-']").attr('readonly', true).prop('disabled', false).show();
        } else {
            $panel.find(":text[id^='date-to-']").attr('readonly', true).daterangepicker().prop('disabled', false).show();
            $panel.find(":text[id^='date-from-']").attr('readonly', true).daterangepicker().prop('disabled', false).show();
        }
    }

    function show_datetime_field($panel) {
        $panel.find(":text[id^='date-to-']").prop('disabled', true).hide().next('.error-help-block').remove();
        $panel.find(":text[id^='date-from-']").prop('disabled', true).hide().next('.error-help-block').remove();

        $panel.find("select[id^='select-to-']").prop('disabled', true).next('.select2-container').hide();
        $panel.find("select[id^='select-from-']").prop('disabled', true).next('.select2-container').hide();

        $panel.find(":text[id^='time-to-']").prop('disabled', true).hide();
        $panel.find(":text[id^='time-from-']").prop('disabled', true).hide();

        if ($panel.find(":text[id^='datetime-to-']").data('daterangepicker')) {
            $panel.find(":text[id^='datetime-to-']").attr('readonly', true).prop('disabled', false).show();
            $panel.find(":text[id^='datetime-from-']").attr('readonly', true).prop('disabled', false).show();
        } else {
            $panel.find(":text[id^='datetime-to-']").attr('readonly', true).daterangepicker().prop('disabled', false).show();
            $panel.find(":text[id^='datetime-from-']").attr('readonly', true).daterangepicker().prop('disabled', false).show();
        }
    }

    function show_time_field($panel) {
        $panel.find(":text[id^='datetime-to-']").prop('disabled', true).hide().next('.error-help-block').remove();
        $panel.find(":text[id^='datetime-from-']").prop('disabled', true).hide().next('.error-help-block').remove();

        $panel.find(":text[id^='date-to-']").prop('disabled', true).hide().next('.error-help-block').remove();
        $panel.find(":text[id^='date-from-']").prop('disabled', true).hide().next('.error-help-block').remove();

        $panel.find("select[id^='select-to-']").prop('disabled', true).next('.select2-container').hide();
        $panel.find("select[id^='select-from-']").prop('disabled', true).next('.select2-container').hide();

        $panel.find(":text[id^='time-to-']").timepicker().prop('disabled', false).show();
        $panel.find(":text[id^='time-from-']").timepicker().prop('disabled', false).show();
        $panel.datepair();
    }

    function inject_range_template(template, container, reverseOrder = false) {

        let $container = $('#' + container);
        let uniqueId = Math.random().toString(36).slice(2);
        let newActionTemplate = $('#'+template).html().replace(/UNIQUEID/g, uniqueId);
        $container.find('.panel-collapse').collapse('hide');
        reverseOrder ? $container.prepend(newActionTemplate) : $container.append(newActionTemplate);

        $container.find("select[name*='range']").select2({
            placeholder: "Select a range",
            data: ranges
        }).on('change', function (event) {
            let $panel = $(event.target).closest('.panel');

            switch (this.value) {
                case 'days':
                    $container.find('.datepicker')
                              .attr('readonly', true)
                              .daterangepicker();

                    show_select_menu($panel, days);
                    break;
                case 'datetimes':
                    show_datetime_field($panel);
                    break;
                case 'dates':
                    show_date_field($panel);
                    break;
                case 'weeks':
                    show_select_menu($panel, weeks);
                    break;
                case 'months':
                    show_select_menu($panel, months);
                    break;
                case 'times':
                case 'sunday':
                case 'monday':
                case 'tuesday':
                case 'wednesday':
                case 'thursday':
                case 'friday':
                case 'saturday':
                    show_time_field($panel);
                    break;
            }
        });

        // Implicit Laravel validation rules does NOT work with `proengsoft/laravel-jsvalidation`
        // so we are attaching validation rules manually for all input fields in the newly added template
        $container.find('.panel-collapse').first().find('input, textarea, select').not('input[name*="unique_field"]').each(function(index, element) {
            $container.closest('form').validate();

            if ($(this).is('select')) {
                $(this).select2();
            }

            if($(this).prop('required')) {
                $(this).rules('add',{
                    required: true,
                });
            }
        });

        $container.find('.panel-collapse').first().collapse('show');
        highlight_required();

        return uniqueId;
    }

    window.addEventListener('turbolinks:load', function() {

        let BookableRangeInit = function(window,$) {

            $('#rateBtn, #availabilityBtn').click(function (event) {
                inject_range_template($(this).data('template'), $(this).data('container'), true);
            });

            $('#service-submit-button').click(function (event) {
                highlight_errored_accordion();
            });

            $(document).on('click', '.removePanel', function () {
                let element = $(this);
                let panel = element.closest('div.template-panel');

                panel.remove();
            });

            let $availabilities = JSON.parse('{!! json_encode(old('availabilities', $service->availabilities)) !!}');
            let $rates = JSON.parse('{!! json_encode(old('rates', $service->rates)) !!}');

            if ($rates) {
                for (let $rate in $rates) {
                    let uniqueId = inject_range_template('rate', 'rates-container');

                    for (let $field in $rates[$rate]) {
                        // Cast boolean to int, for select menus!
                        $rates[$rate][$field] = typeof($rates[$rate][$field]) === 'boolean' ? +$rates[$rate][$field] : $rates[$rate][$field];

                        setTimeout(function(){
                            $("[name='rates["+uniqueId+"]["+$field+"]']").val($rates[$rate][$field]).trigger('change');
                        }, 10);
                    }
                }
            }

            if ($availabilities) {
                for (let $availability in $availabilities) {
                    let uniqueId = inject_range_template('availability', 'availabilities-container');

                    for (let $field in $availabilities[$availability]) {
                        // Cast boolean to int, for select menus!
                        $availabilities[$availability][$field] = typeof($availabilities[$availability][$field]) === 'boolean' ? +$availabilities[$availability][$field] : $availabilities[$availability][$field];

                        setTimeout(function(){
                            $("[name='availabilities["+uniqueId+"]["+$field+"]']").val($availabilities[$availability][$field]).trigger('change');
                        }, 10);
                    }
                }
            }
        }

        // Fired only once when turbolinks enabled (the very begining visit or hard refresh)
        $(document).on('bookablerange.ready', function () {
            BookableRangeInit(window, $);
        });

        // Assigned after the first load of the page or hard refresh
        if (window.BookableRangeReady) {
            BookableRangeInit(window, $);
        }

    });

</script>

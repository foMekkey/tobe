@extends('backend.layouts.app')

@section('style')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
@endsection

@section('content')

    <div class="message"></div>

    @include('errors.messages')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        <div class="row">
            <div class="col-lg-12">

                <!--begin::Portlet-->
                <div class="kt-portlet" id="kt_portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                                <i class="flaticon-calendar-2"></i>
                            </span>
                            <h3 class="kt-portlet__head-title">
                                {{ __('pages.events') }}
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="#" class="btn btn-brand btn-elevate" data-toggle="modal" data-target="#AddModel">
                                <i class="la la-plus"></i>
                                {{ __('pages.add-event') }}
                            </a>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                       <div id="calendar"></div>
                    </div>
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="AddModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('pages.add-event') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display: none" id="add-alert">
                        الرجاء ملىء جميع الحقول
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event-name') }}:</label>
                        <input type="text" class="form-control" id="name" name="name" required="">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event_start') }}:</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" required="">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event_end') }}:</label>
                        <input type="date" class="form-control" name="end_date" id="end_date" required="">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.close') }}</button>
                    <button type="button" id="appointment_save" class="btn btn-primary">{{ __('pages.save') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!--end::Modal-->

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('pages.event-name') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="event_id" value=""/>
                    <input type="hidden" name="type" id="event_type" value=""/>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event') }}:</label>
                        <input type="text" class="form-control" id="name_event" name="name" value="">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event_start') }}:</label>
                        <input type="date" class="form-control" name="start_date_event" id="start_date_event" value="">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="form-control-label">{{ __('pages.event_end') }}:</label>
                        <input type="date" class="form-control" name="end_date_event" id="end_date_event" value="">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('pages.close') }}</button>
                    <button type="button" id="appointment_edit" class="btn btn-primary">{{ __('pages.save') }}</button>
                    <button type="button" id="appointment_delete" class="btn btn-danger">{{ __('pages.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewMeetingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('pages.show-meeting') }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            {{ __('pages.name-meet') }} :
                        </div>
                        <div class="col-lg-9" id="meeting_name"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ __('pages.start') }} :
                        </div>
                        <div class="col-lg-9" id="meeting_date_time"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            {{ __('pages.period') }} :
                        </div>
                        <div class="col-lg-9" id="meeting_period"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3" id="meeting_join_container">
                            {{ __('pages.meeting-join_url') }} :
                        </div>
                        <div class="col-lg-9" id="meeting_join"></div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/locale/ar-sa.js'></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(document).on('click', '.fc-content', function () {
            var id = $('#event_id').val();
            var eventType = $('#event_type').val();

            if (eventType == '1') {
                $.ajax({
                    type: "GET",
                    url: "{{ url('trainer/events/edit') }}" + '/' + id/* + '/' + $('#event_type').val()*/,
                    dataType: "json",
                    success: function (msg) {
                        var name_event = msg.event.name;
                        var start_date_event = msg.event.start_date;
                        var end_date_event = msg.event.end_date;

                         $('#name_event').val(name_event);
                         $('#start_date_event').val(start_date_event);
                         $('#end_date_event').val(end_date_event);

                         $('#editModal').modal();
                    }
                });
            } else if (eventType == '2') {
                $.ajax({
                    type: "GET",
                    url: "{{ url('trainer/meeting/ajaxShow') }}" + '/' + id/* + '/' + $('#event_type').val()*/,
                    dataType: "json",
                    success: function (msg) {
                        $('#meeting_name').text(msg.meeting.name);
                        $('#meeting_date_time').text(msg.meeting.date + ' ' + msg.meeting.time);
                        $('#meeting_period').text(msg.meeting.period + " {{ __('pages.minutes') }}");

                        /*var meetingDateTime = new Date(msg.meeting.date + ' ' + msg.meeting.time);
                        var currentTime = new Date();
                        var diff = Math.round((currentTime - meetingDateTime) / 60000);
                        if (diff >= 0 && diff < msg.meeting.period) {*/
                        if (msg.meeting.is_running !== '') {
                            $('#meeting_join').html('<a class="btn btn-primary" href="{{ url("trainer/meeting/start") }}/' + id + '" target="_blank">{{ __("pages.join") }}</a>');
                            $('#meeting_join_container').show();
                        } else {
                            $('#meeting_join').text("");
                            $('#meeting_join_container').hide();
                        }

                        $('#viewMeetingModal').modal();
                    }
                });
            }
        });

        $("#appointment_edit").on('click', function (event) {
        //$(document).on('click', '#appointment_edit', function (event) {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var field1value = $("#name_event").val();
            var field1start = $("#start_date_event").val();
            var field1end = $("#end_date_event").val();

            $.ajax({
                type: "POST",
                url: "{{ url('trainer/events/appointments_ajax_update') }}" + '/' + $('#event_id').val(),
                data: {'_token': "{{ csrf_token() }}", 'name': field1value,'start_date':field1start,'end_date':field1end},
                dataType: "json",
                success: function (msg) {
                    $('#editModal').modal('hide');
                    location.reload();
                   // $( "#calendar" ).load(window.location.href + " #calendar" );
                }
            });
        });

        $("#appointment_delete").on('click', function (event) {
            var id = $('#event_id').val();

            event.preventDefault();
            $.ajax({
                type: "GET",
                url: "{{ url('trainer/events/delete') }}" + '/' + id,
                dataType: "json",
                success: function (msg) {
                    console.log(msg);
                    //   $("#event-name").val('');
                    $('#editModal').modal('hide');
                }
            });
        });

        $("#appointment_save").on('click', function () {
            event.preventDefault();
            var field1value = $("#name").val();
            var field1start = $("#start_date").val();
            var field1end = $("#end_date").val();
            if (!field1value || !field1start || !field1end) {
                $('#add-alert').show();
                return false;
            } else {
                $('#add-alert').hide();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('postaddeventTrainer') }}",
                    data: {'name': field1value,'start_date':field1start,'end_date':field1end},
                    dataType: "json",
                    success: function (msg) {
                        console.log(msg);
                     //   $("#event-name").val('');
                        $('#AddModel').modal('hide');
                        location.reload();
                    }
                });
            }
        });

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                isRTL: true,
                locale: "ar-sa",
                events : [
                    @foreach($appointments as $appointment)
                    {
                        id: '{{ $appointment->id }}',
                        type: 1,
                        title : '{{ $appointment->name}}',
                        start : '{{ $appointment->start_date }}',
                        end: '{{ $appointment->end_date }}',
                    },
                    @endforeach

                    @foreach($meetings as $meeting)
                    {
                        id: '{{ $meeting->id }}',
                        type: 2,
                        title : '{{ $meeting->name}}',
                        start : '{{ $meeting->date }}',
                        end: '{{ $meeting->date }}',
                        backgroundColor: 'yellow',
                    },
                    @endforeach
                ],
                eventClick: function(calEvent, jsEvent, view) {
                  //  console.log(moment(calEvent.start).format('YYYY-MM-DD'));
                    $('#event_id').val(calEvent.id);
                    $('#event_type').val(calEvent.type);
                    //$('#start_datee').val(moment(calEvent.start).format('YYYY-MM-DD'));
                    //$('#end_datee').val(moment(calEvent.end).format('YYYY-MM-DD'));
                    /*if (calEvent.type == '1') {
                        $('#editModal').modal();
                    } else if (calEvent.type == '2') {
                        $('#viewMeetingModal').modal();
                    }*/
                }
            });
        });
    </script>
@endsection

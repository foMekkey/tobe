@extends('site.layouts.app')

@section('styles')
    <link href="{{ asset('site_assets') }}/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <style>
        .alert {
            font-size: 20px;
        }
        .form-control[readonly] {
            background: #fff;
            @if(app()->getLocale() == 'ar') direction: rtl; @endif
        }
    </style>
@endsection

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.consultation_request') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('site/consult') }}">{{ __('site.consultation') }}</a></li>
            </ul>
        </div>
    </section>
    
    <section class="contact">
        <div class="container-fluid">
            <div class="row">
                <h1>{{ __('site.consultation_request') }}</h1>
                <form id="add_consult_form" enctype="multipart/form-data">
                    <div id="add_consult-alert" class="alert alert-success" role="alert" style="display: none"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="text" class="form-control datepicker" placeholder="{{ __('site.date') }}" name="date" value="" readonly="">
                            <span class="fa fa-calendar-alt"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __('site.hours') }}" name="hours">
                            <span class="fa fa-clock"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <select class="form-control" name="session_type">
                                <option value="">{{ __('site.session_type') }}</option>
                                <option value="1">{{ __('site.direct') }}</option>
                                <option value="2">{{ __('site.remotely') }}</option>
                            </select>
                            <span class="fa fa-tasks"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="file" name="file" class="form-control" placeholder="{{ __('site.upload_file') }}" style="padding-top: 20px;padding-left: 50px;cursor: pointer;">
                            <span class="fa fa-upload"></span>
                            <i style="position: absolute;width:92px;height: 58px;line-height: 62px;top: 1px;{{ __('site.left') }}: 50px; background-color: #fff;color: #979797;">{{ __('site.upload_file') }}</i>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <textarea class="form-control" placeholder="{{ __('site.consultation_subject') }}" name="subject"></textarea>
                            <span class="fa fa-pen"></span>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            @csrf
                            <input type="submit" class="btn black_hover" value="{{ __('site.send') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('site_assets') }}/js/bootstrap-datepicker.min.js"></script>
    @if(app()->getLocale() == 'ar')
        <script src="{{ asset('site_assets') }}/js/bootstrap-datepicker.ar.min.js"></script>
        <script>
            $('.datepicker').datepicker({startDate: '+1', autoclose: true, format: "yyyy/mm/dd", rtl: true, language: 'ar'});
        </script>
    @else
        <script>
            $('.datepicker').datepicker({startDate: '+1', autoclose: true, format: "yyyy/mm/dd"});
        </script>
    @endif
    
    <script>        
        $('#add_consult_form').validate({rules: {
            date: 'required',
            hours: 'required',
            session_type: 'required',
            subject: 'required'
        }});
    
        $("#add_consult_form").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();

            if(!$(this).valid()) return false;
            
            $('#add_consult').prop("disabled", true);
            $('#add_consult').html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );
    
            var formData = new FormData($(this)[0]);
            if ($('#file')[0]) {
                formData.append('file', $('#file')[0].files[0]);
            }
            $.ajax({
                url: "{{ url('site/consult') }}",
                type: 'post',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        $('#add_consult-alert').removeClass('alert-danger');
                        $('#add_consult-alert').addClass('alert-success');
                        $('#add_consult-alert').text("{{ __('site.add_consult_success') }}");
                        $('#add_consult-alert').show();
                        $('#add_consult_form').trigger("reset");
                    } else {
                        $('#add_consult-alert').removeClass('alert-success');
                        $('#add_consult-alert').addClass('alert-danger');
                        $('#add_consult-alert').text("{{ __('site.add_consult_error') }}");
                        $('#add_consult-alert').show();
                    }
                    
                    $('#add_consult').prop("disabled", false);
                    $('#add_consult').text("{{ __('site.send') }}");
                    
                    $('html, body').animate({
                        scrollTop: $("#add_consult-alert").offset().top - 50
                    }, 1000);
                }
            });
        });
    </script>
@endsection
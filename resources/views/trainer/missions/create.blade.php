@extends('backend.layouts.app')

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <style>
        .bootstrap-tagsinput {
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            display: block;
            padding: 4px 6px;
            color: #555;
            vertical-align: middle;
            border-radius: 4px;
            max-width: 100%;
            line-height: 22px;
            cursor: text;
        }
        .bootstrap-tagsinput input {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: transparent;
            padding: 0 6px;
            margin: 0;
            width: auto;
            max-width: inherit;
        }

        .label-info {
            background-color: #5bc0de;
            padding: 3px;
        }
    </style>
@endsection

@section('content')

    @include('errors.messages')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ __('pages.create-mission') }}
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postaddmissionsTrainer') }}" enctype="multipart/form-data">
                @csrf
                <div class="kt-portlet__body">
                    <div class="kt-form__content">
                        <div class="kt-alert m-alert--icon alert alert-danger kt-hidden" role="alert" id="kt_form_1_msg">
                            <div class="kt-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="kt-alert__text">
                                Oh snap! Change a few things up and try submitting again.
                            </div>
                            <div class="kt-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.send-to') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select name="mission_to" id="mission_to" class="form-control">
                                <option value="1" selected="">{{ __('pages.Student') }}</option>
                                <option value="2">{{ __('pages.group') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">&nbsp;</label>
                        <div class="col-lg-9 col-xl-9">
                            <div id="student_id_container">
                                <select name="student_id" id="student_id" class="form-control select2">
                                    <option value="">{{ __('pages.choose-student') }}</option>
                                    @foreach($students as $student)
                                        <option value="{{$student->id}}">{{$student->user_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div id="group_id_container" style="display: none">
                                <select name="group_id" id="group_id" class="form-control">
                                    <option value="">{{ __('pages.choose-group') }}</option>
                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}">{{$group->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.title') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" id="kt_name" name="name" type="text" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.desc') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea class="form-control" name="desc" rows="5">{{ old('desc') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.attach_file') }} </label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="file" name="file" id="file" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.peroid') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" name="period" class="form-control" value="{{ old('period') }}"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.date') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input type='text' class="form-control" id="datepickerr" readonly placeholder="" name="expire_date" value="{{ old('expire_date') }}"/></div>
                    </div>
                </div>
                <div class="kt-form__actions">
                    <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                        {{ __('pages.save') }}
                    </button>
                </div>
            </form>

            <!--end::Form-->
        </div>
        <!--end::Portlet-->
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
    <script>
        $('.select2').select2();

        $.fn.datepicker.dates['ar'] = {
            days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
            daysShort: ["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت", "أحد"],
            daysMin: ["ح", "ن", "ث", "ع", "خ", "ج", "س", "ح"],
            months: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            monthsShort: ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            today: "هذا اليوم",
            rtl: true
        };
        $('#datepickerr').datepicker({
            language: 'ar',
            format: "mm/dd/yyyy",
        });
        
        $(document).ready(function () {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    name: {
                        required: true,
                    },
                    desc: {
                        required: true,
                    },
                    mission_to: {
                        required: true,
                    },
                    expire_date: {
                        required: true,
                    },
                    student_id: {
                        required: function(element){
                            return $("#mission_to").val() == '1';
                        }
                    },
                    group_id: {
                        required: function(element){
                            return $("#mission_to").val() == '2';
                        }
                    }
                },
                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },
            });
            
            $('#mission_to').change(function() {
                if ($(this).val() == '1') {
                    $('#student_id_container').show();
                    $('#group_id_container').hide();
                } else {
                    $('#student_id_container').hide();
                    $('#group_id_container').show();
                }
            });
        });
    </script>
@endsection

@extends('backend.layouts.app')

@section('style')
    <style>
        .remove_btn {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #f00000;
            display: block;
            color: #fff !important;
            font-size: 26px;
            line-height: 18px;
            font-weight: bold;
            cursor: pointer;
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
                        {{ __('pages.create-survey') }}
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postaddsurveysTrainer', $courseId) }}">
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
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.Type') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select name="is_day_star" class="form-control" id="is_day_star">
                                <option value="0" selected="">{{ __('pages.survey') }}</option>
                                <option value="1">{{ __('pages.day-star') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.title') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" id="kt_name" name="title" type="text" value="{{ old('title') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.date') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input type='text' class="form-control" id="datepickerr" readonly placeholder="" name="date" value="{{ old('date') }}"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">{{ __('pages.show_results_in_course') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <div class="kt-checkbox-single" style="margin-top: 6px;">
                                <label class="kt-checkbox">
                                    <input type="checkbox" name="show_results_in_course" value="1">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-3 col-form-label">{{ __('pages.status') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <div class="kt-checkbox-single" style="margin-top: 6px;">
                                <label class="kt-checkbox">
                                    <input type="checkbox" name="status" value="1" checked="">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="questions-container">
                        <label class="col-3 col-form-label">{{ __('pages.questions') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="35%" class="text-center">{{ __('pages.question') }}</th>
                                        <th width="15%" class="text-center">{{ __('pages.question_type') }}</th>
                                        <th width="35%" class="text-center allowed_options_cell">{{ __('pages.available_options') }}</th>
                                        <th width="10%" class="text-center">{{ __('pages.required') }}</th>
                                        <th width="5%" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="questions">
                                    <tr>
                                        <td><input class="form-control" name="questions[question][]" /></td>
                                        <td>
                                            <select class="form-control question_type" name="questions[type][]" required="">
                                                <option value="1">{{ __('pages.text') }}</option>
                                                <option value="2" selected="">{{ __('pages.question-select') }}</option>
                                                {{-- <option value="3">{{ __('pages.question-multi-select') }}</option> --}}
                                            </select>
                                        </td>
                                        <td class="allowed_options_cell"><textarea class="form-control allowed_options" name="questions[allowed_options][]" rows="3"></textarea></td>
                                        <td class="text-center"><input type="checkbox" name="questions[is_required][]" value="1" checked=""></td>
                                        <td class="text-center"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <center>
                                <a href="javascript:void(0)" class="btn btn-success" id="add_more_btn"><i class="fa fa-plus"></i> {{ __('pages.add_more_question') }}</a>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="kt-form__actions">
                    @csrf
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
    <script>
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
                    title: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    'questions[]': {
                        required: true,
                    }
                },
                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },
            });
            
            $('#is_day_star').change(function() {
                if ($(this).val() == '1') {
                    $('.allowed_options_cell').hide();
                } else {
                    $('.allowed_options_cell').show();
                }
            });
            
            $(document).on('change', '.question_type', function() {
                if ($(this).val() == '1') {
                    $(this).parent().parent().find('.allowed_options').hide();
                } else {
                    $(this).parent().parent().find('.allowed_options').show();
                }
            });
            
            $(document).on('click', '.remove_btn', function() {
                $(this).parent().parent().remove();
            });
            $('#add_more_btn').click(function() {
                $('#questions').append(`<tr>
                                            <td><input class="form-control" name="questions[question][]" /></td>
                                            <td>
                                                <select class="form-control question_type" name="questions[type][]" required="">
                                                    <option value="1">{{ __('pages.text') }}</option>
                                                    <option value="2" selected="">{{ __('pages.question-select') }}</option>
                                                    <option value="3">{{ __('pages.question-multi-select') }}</option>
                                                </select>
                                            </td>
                                            <td class="allowed_options_cell"><textarea class="form-control allowed_options" name="questions[allowed_options][]" rows="3"></textarea></td>
                                            <td class="text-center"><input type="checkbox" name="questions[is_required][]" value="1" checked=""></td>
                                            <td class="text-center">
                                                <a class="remove_btn">-</a>
                                            </td>
                                        </tr>`);
            });
        });
    </script>
@endsection

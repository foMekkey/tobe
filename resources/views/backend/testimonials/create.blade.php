@extends('backend.layouts.app')

@section('content')
    @include('errors.messages')
    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">

        <!--begin::Portlet-->
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ __('pages.add-new-testimonial') }}
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postaddtestimonials') }}" enctype="multipart/form-data">
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
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.user') }}  <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            {{Form::select('user_id',$users, old('user_id'),['class'=>'form-control select2','placeholder'=>__('pages.choose-user')])}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.message') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea  class="form-control" name="message" id="exampleTextarea" rows="3" spellcheck="false">{{ old('message') }}</textarea></div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.created') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input type='text' class="form-control" id="datepickerr" readonly placeholder="" name="datetime" value="{{ old('datetime') }}"/></div>
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
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "{{ __('pages.choose-user') }}",
            });
            
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
                endDate: '0d'
            });
            
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    user_id: {
                        required: true
                    },
                    message: {
                        required: true,
                    },
                    datetime: {
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

        });
    </script>
@endsection

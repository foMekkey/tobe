@extends('backend.layouts.app')
@section('style')
    <style>
        .slidecontainer {
            width: 100%;
        }

        .slider {
            -webkit-appearance: none;
            width: 100%;
            height: 25px;
            background: #d3d3d3;
            outline: none;
            opacity: 0.7;
            -webkit-transition: .2s;
            transition: opacity .2s;
        }

        .slider:hover {
            opacity: 1;
        }

        .slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

        .slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            background: #4CAF50;
            cursor: pointer;
        }

    </style>
@endsection
@section('content')

    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

    @include('errors.messages')

    <!--end: Form Wizard Nav -->
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                        <!--begin: Form Wizard Form-->
                        <form class="kt-form kt-form--label-right" id="kt_form_1" method="post"
                              action="{{ route('postupdatediscussionStudent') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$discussion->id}}">
                        <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content"
                                 data-ktwizard-state="current">
                                <div class="kt-portlet__head kt-portlet__head--lg" style="">
                                    <div class="kt-portlet__head-label">
                                        <h2 class="kt-portlet__head-title">{{ __('pages.edit-discussion') }} : {{$discussion->title}}</h2>
                                    </div>
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-wizard-v4__form">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.subject') }}
                                                        <span style="color: red">*</span></label>
                                                    <div class="col-lg-5 col-xl-5">
                                                        <input class="form-control" name="title" type="text" value="{{ $discussion->title }}" placeholder="{{ __('pages.subject') }}" required="">
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.message') }} 
                                                    <span style="color: red">*</span> </label>
                                                    <div class="col-lg-9 col-xl-9">
                                                    <textarea class="form-control" name="body" id="exampleTextarea" placeholder="{{ __('pages.message') }}" rows="7" spellcheck="false" required="">{{ $discussion->body }}</textarea></div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-3 col-xl-3">{{ __('pages.choose-attachment') }}</label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input class="form-control" name="attachment" type="file" >
                                                    </div>
                                                </div>

                                                @if(!is_null($discussion->attachment))
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-lg-3 col-xl-3">{{ __('pages.current-attachment') }}</label>
                                                        <div class="col-lg-9 col-xl-9">
                                                            <a href="{{URL::to('uploads/attachment/'.$discussion->attachment)}}" target="_blank">تحميل</a>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-form-label col-lg-3 col-xl-3">{{ __('pages.privacy') }}</label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <select class="form-control" name="privacy">
                                                            <option value="1">{{ __('pages.all-can-show-discussions') }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <!--end: Form Wizard Step 1-->

                            <!--begin: Form Actions -->
                            <div class="kt-form__actions">

                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                        type="submit">
                                    {{ __('pages.save') }}
                                </button>

                            </div>

                            <!--end: Form Actions -->
                        </form>
                        <!--end: Form Wizard Form-->
                    </div>
                </div>
            </div>
        </div>
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
                    name: {
                        required: true,
                    },
                    date: {
                        required: true,
                    },
                    message: {
                        required: true,
                    },
                    period: {
                        required: true,
                    },


                },

                messages: {
                    name: "{{__('jsMessage.name')}}",
                    date: "{{__('jsMessage.date')}}",
                    message: "{{__('jsMessage.message')}}",
                    period: "{{__('jsMessage.period')}}",

                },
                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },

            });

            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value;

            slider.oninput = function () {
                output.innerHTML = this.value;
                $('#period').val(this.value);
            }

        });
    </script>
@endsection

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
                        {{ __('pages.add-new-course') }}
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postaddcourses') }}" enctype="multipart/form-data">
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
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.profile') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_apps_user_add_avatar">
                                <div class="kt-avatar__holder" id="imagePreview" style="background-image: url({{ asset('uploads/courses/download.jpeg') }});"></div>
                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                    <i class="fa fa-pencil"></i>
                                    <input type="file" name="image" id="imageUpload" >
                                </label>
                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
																							<i class="fa fa-times"></i>
																</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.author') }}  <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            {{Form::select('user_id',$trainers,null,['class'=>'form-control','placeholder'=> __('pages.choose-trainer'), 'required'=>'required'])}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.language') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control"  name="lang" >
                                <option value="" selected> {{ __('pages.choose-language') }} </option>
                                <option value="ar"> {{ __('pages.language-ar') }} </option>
                                <option value="en"> {{ __('pages.language-en') }} </option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.course-name') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="name" type="text" value="{{ old('name') }}">
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.category') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            {{Form::select('category_id',$categories,null,['class'=>'form-control','id'=>'kt_category','placeholder'=> __('pages.choose-category')])}}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.level') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control"  name="level" id="kt_level" >
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor

                            </select>

                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.desc') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea  class="form-control" name="desc" id="exampleTextarea" rows="3" spellcheck="false">{{ old('desc') }}</textarea>                                                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.content') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea id="summernote" name="content">{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.data-start-and-end') }}   <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  type='text' class="form-control" id="daterangepicker" readonly placeholder="Select time" name="dateRange" />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.price') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  type="number" name="price" class="form-control" value="{{ old('price') }}"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-xl-12 col-lg-12">
                            <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.peroid') }} <span style="color: red">*</span></label>
                            <div class="col-lg-9 col-xl-9">
                                <input type="number"  name="duration" class="form-control" value="{{ old('duration') }}"  />
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.period_type') }} <span style="color: red">*</span></label>
                            <div class="col-lg-9 col-xl-9">
                                <select name="period_type" class="form-control" id="period_type">
                                    <option value="hour" @if( {{ old('period_type') }} == 'hour') selected='selected' @endif>{{__('pages.hour')}}</option>
                                    <option value="day" @if( {{ old('period_type') }} == 'day') selected='selected' @endif>{{__('pages.day')}}</option>
                                    <option value="week" @if( {{ old('period_type') }} == 'week') selected='selected' @endif>{{__('pages.week')}}</option>
                                    <option value="month" @if( {{ old('period_type') }} == 'month') selected='selected' @endif>{{__('pages.month')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.rules_of_achievement') }}</label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea class="form-control" name="complete_rules" rows="3" spellcheck="false"></textarea>                                                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.tag') }} </label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="text" name="tags" class="form-control" value="" data-role="tagsinput" />
                        </div>
                    </div>


                    <div class="form-group form-group-last row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.types') }}</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="kt-checkbox-inline">
                                <label class="kt-checkbox">
                                    <input type="checkbox" name="status" value="1">{{ __('pages.status') }}
                                    <span></span>
                                </label>
                                <label class="kt-checkbox">
                                    <input type="checkbox" name="hide_from_catalog" value="1">{{ __('pages.catalog') }}
                                    <span></span>
                                </label>
                            </div>
                        </div>
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
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/forms/widgets/bootstrap-daterangepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/summernote.min.js') }}" type="text/javascript"></script>    
    <script>
        var italian_daterangepicker = {
            "direction": "rtl",
            "format": "MM/DD/YYYY",
            "separator": " - ",
            "applyLabel": "عرض",
            "cancelLabel": "إغلاق",
            "fromLabel": "Da",
            "toLabel": "A",
            "isRTL": true,
            "customRangeLabel": "Personalizzata",
            "daysOfWeek": [
                'ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'
            ],
            "monthNames": [
                "يناير",
                "فبراير",
                "مارس",
                "ابريل",
                "مايو",
                "يونيو",
                "يوليو",
                "اغسطس",
                "سبتمبر",
                "اكتوبر",
                "نوفمبر",
                "ديسمبر"
            ],
            "firstDay": 1
        };
        $('#daterangepicker').daterangepicker({
            locale : italian_daterangepicker,
            singleDatePicker: false,
        });

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });


        // $("input").tagsinput('items');


        $(document).ready(function () {
            $('#daterangepicker').validate();
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    select2: {
                        required: true
                    },
                    name: {
                        required: true,
                    },
                    lang: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                    level: {
                        required: true,
                    },
                    select: {
                        required: true,
                    },
                    desc: {
                        required: true,
                    },

                    price: {
                        required: true,
                    },
                    duration: {
                        required: true,
                    },
                },

                messages: {
                    name: "{{__('jsMessage.name')}}",
                    category_id: "{{__('jsMessage.category_id')}}",
                    level: "{{__('jsMessage.level')}}",
                    desc: "{{__('jsMessage.desc')}}",
                    price: "{{__('jsMessage.price')}}",
                    duration: "{{__('jsMessage.duration')}}",

                },
                //display error alert on form submit
                invalidHandler: function (event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },

            });

        });

        $('#summernote').summernote({
            callbacks: {
                onImageUpload: function(files) {
                    for(let i=0; i < files.length; i++) {
                        $.upload(files[i]);
                    }
                }
            },
            height: 300,
        });

        $.upload = function (file) {
            let out = new FormData();
            out.append('file', file, file.name);

            $.ajax({
                method: 'POST',
                url: '{{ url('upload') }}',
                contentType: false,
                cache: false,
                processData: false,
                data: out,
                success: function (img) {
                    $('#summernote').summernote('insertImage', img);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus + " " + errorThrown);
                }
            });
        };
    </script>
@endsection

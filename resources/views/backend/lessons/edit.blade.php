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
                        {{ __('pages.edit-lesson') }}
                    </h3>
                </div>
            </div>


            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postupdatelessons',['course_id'=>$course_id ,'lesson_id'=>$lesson->id]) }}" enctype="multipart/form-data">
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
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.lesson-number') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="number_lession" type="text" value="{{ $lesson->number_lession }}">
                        </div>
                    </div>


                    {{--<input type="hidden" value="{{ $id }}" name="course_id" >--}}

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.sort') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="sort" type="number" value="{{ $lesson->sort }}">
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.lesson-name') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="name" type="text" value="{{ $lesson->name }}">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.Type') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select name="type" class="form-control" id="TypeInput">
                                <option selected>{{ __('pages.choose-section') }}</option>
                                @foreach($courseTypes as $key=>$value)
                                    <option value="{{$key}}" @if($key == $lesson->type) selected  @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row" style="display:none;" id="numberQuestion">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.numberQuestion') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input type="number" name="numberQuestion"  value="{{ $lesson->numberQuestion }}" class="form-control">
                        </div>
                    </div>




                    <div class="form-group row" id="content" @if($lesson->type == 1 || $lesson->type == 2)style="display:none;"@endif>
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.content') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea  class="form-control" name="content" id="exampleTextarea" rows="7" spellcheck="false">{{ $lesson->content }}</textarea>                                                        </div>
                    </div>


                    <div class="form-group row" id="fileContainer" @if($lesson->type == 3 || $lesson->type == 4)style="display:none;"@endif>
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.file') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  type="file" name="file" class="form-control" value="{{ old('file') }}"  />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.period') }} <span style="color: red">*</span></label>
                        <div class="col-lg-3 col-xl-3">
                            <input type="number"  name="period" class="form-control" value="{{ $lesson->period }}"  />
                        </div>
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.period_type') }} <span style="color: red">*</span></label>
                        <div class="col-lg-3 col-xl-3">
                            <select name="period_type" class="form-control" id="period_type">
                                <option value="hour" @if ( $lesson->period_type == 'hour') selected='selected' @endif>{{ __('pages.hour') }}</option>
                                <option value="day" @if ( $lesson->period_type == 'day') selected='selected' @endif>{{ __('pages.day') }}</option>
                                <option value="week" @if ( $lesson->period_type == 'week') selected='selected' @endif>{{ __('pages.week') }}</option>
                                <option value="month" @if ( $lesson->period_type == 'month') selected='selected' @endif>{{ __('pages.month') }}</option>
                            </select>
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
    <script>
        $(function() {
            $('#TypeInput').change(function(){
                if($(this).val() == 1 || $(this).val() == 2) {
                    $('#numberQuestion').hide();
                    $('#content').hide();
                    $('#fileContainer').show();
                } else {
                    $('#numberQuestion').hide();
                    $('#fileContainer').hide();
                    $('#content').show();
                }
            });
        });

        // $("input").tagsinput('items');


        $(document).ready(function () {

            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    name: {
                        required: true,
                    },
                    sort: {
                        required: true,
                    },
                    number_lession: {
                        required: true,
                    },
                    content: {
                        required: function(element){
                            return ($("#TypeInput").val() == 3 || $("#TypeInput").val() == 4);
                        }
                    },

                    period: {
                        required: true,
                    },
                },

                messages: {
                    name: "{{__('jsMessage.name')}}",
                    sort: "{{__('jsMessage.sort')}}",
                    number_lession: "{{__('jsMessage.number_lession')}}",
                    content: "{{__('jsMessage.content')}}",
                    period: "{{__('jsMessage.period')}}",

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

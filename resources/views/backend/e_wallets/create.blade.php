@extends('backend.layouts.app')

@section('style')
<link href="{{ asset('css/summernote.css') }}" rel="stylesheet" type="text/css" />
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
                        {{ __('pages.add-new-e_wallet') }}
                    </h3>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postadde_wallet') }}" enctype="multipart/form-data">
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
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.wallet_number') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="number" type="text" value="{{ old('number') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.company_name_ar') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="company_name_ar" type="text" value="{{ old('company_name_ar') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.company_name_en') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="company_name_en" type="text" value="{{ old('company_name_en') }}">
                        </div>
                    </div>
                    <div class="form-group form-group-last row">
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.types') }}</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="kt-checkbox-inline">
                                <label class="kt-checkbox">
                                    <input type="radio" name="active" value="1" checked>{{ __('pages.active') }}
                                    
                                    <span></span>
                                </label>
                                
                            </div>
                            <div class="kt-checkbox-inline">
                                <label class="kt-checkbox">
                                    <input type="radio" name="active" value="0" >{{ __('pages.notactive') }}
                                    
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
    <script src="{{ asset('js/summernote.min.js') }}" type="text/javascript"></script>    
    <script>
    
        $(document).ready(function () {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    number: {
                        required: true,
                    },
                    company_name_ar: {
                        required: true,
                    },
                    company_name_en: {
                        required: true,
                    },
                    active:{
                        required: true
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

@extends('backend.layouts.app')

@section('page-main-title', __('pages.courses'))

@section('content')

    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

    @include('errors.messages')

    <!--end: Form Wizard Nav -->
        <div class="kt-portlet">

            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                        <!--begin: Form Wizard Form-->
                        <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postaddgroupsStudent') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                <div class="kt-portlet__head kt-portlet__head--lg" style="">
                                    <div class="kt-portlet__head-label">
                                        <h2 class="kt-portlet__head-title">
                                            {{ __('pages.join-to-group') }}
                                        </h2>
                                    </div>
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-wizard-v4__form">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label" style="
    text-align: right;
    max-width: max-content;
"> {{ __('pages.key-group') }}  <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input  class="form-control" name="key" type="text" value="{{ old('key') }}">
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
                                <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" style="
    margin: 10px;
">
                                    {{ __('pages.join') }}
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
        $(document).ready(function () {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    key: {
                        required: true,
                    },
                },

                messages: {
                    key: "{{__('jsMessage.key')}}",
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

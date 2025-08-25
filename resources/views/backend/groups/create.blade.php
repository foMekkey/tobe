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
    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">

        @include('errors.messages')

        <!--end: Form Wizard Nav -->
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                        <!--begin: Form Wizard Form-->
                        <form class="kt-form kt-form--label-right" id="kt_form_1" method="post"
                            action="{{ route('postaddgroups') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content"
                                data-ktwizard-state="current">
                                <div class="kt-portlet__head kt-portlet__head--lg" style="">
                                    <div class="kt-portlet__head-label">
                                        <h2 class="kt-portlet__head-title">{{ __('pages.add-new-group') }}</h2>
                                    </div>
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-wizard-v4__form">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">
                                                        {{ __('pages.name-group') }} <span
                                                            style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input class="form-control" name="name" type="text"
                                                            value="{{ old('name') }}">
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">
                                                        {{ __('pages.Trainer') }} <span style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">

                                                        {{ Form::select('trainer_id', $trainers, null, ['class' => 'form-control', 'placeholder' => __('pages.choose-trainer'), 'required' => 'required']) }}


                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.desc') }}
                                                    </label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <textarea class="form-control" name="desc" id="exampleTextarea" rows="3" spellcheck="false"></textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">
                                                        {{ __('pages.group-key') }} </label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input class="form-control" name="key" type="text" readonly
                                                            value="{{ mt_rand(100000, 999999) }}">
                                                    </div>
                                                </div>




                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.tag') }}
                                                    </label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input type="text" name="tags" class="form-control"
                                                            value="" data-role="tagsinput" />
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-3 col-form-label">{{ __('pages.status') }}</label>
                                                    <div class="col-9">
                                                        <div class="kt-checkbox-single">
                                                            <label class="kt-checkbox">
                                                                <input type="checkbox" name="status" value="1">
                                                                <span></span>
                                                            </label>
                                                        </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });



        $(document).ready(function() {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    name: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },


                },

                messages: {
                    name: "{{ __('jsMessage.name') }}",
                    trainer_id: "{{ __('jsMessage.trainer_id') }}",

                },
                //display error alert on form submit
                invalidHandler: function(event, validator) {
                    var alert = $('#kt_form_1_msg');
                    alert.removeClass('kt--hide').show();
                    KTUtil.scrollTo('m_form_1_msg', -200);
                },

            });

        });
    </script>
@endsection

@extends('backend.layouts.app')

@section('style')
    <style>
        .tree,
        .tree ul {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .tree ul {
            margin-left: 1em;
            position: relative
        }

        .tree ul ul {
            margin-left: .5em
        }

        .tree ul:before {
            content: "";
            display: block;
            width: 0;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            border-left: 1px solid
        }

        .tree li {
            margin: 0;
            padding: 0 1em;
            line-height: 2em;
            color: #369;
            font-weight: 700;
            position: relative
        }

        .tree ul li:before {
            content: "";
            display: block;
            width: 10px;
            height: 0;
            border-top: 1px solid;
            margin-top: -1px;
            position: absolute;
            top: 1em;
            left: 0
        }

        .tree ul li:last-child:before {
            background: #fff;
            height: auto;
            top: 1em;
            bottom: 0
        }

        .indicator {
            margin-right: 5px;
        }

        .tree li a {
            text-decoration: none;
            color: #369;
        }

        .tree li button,
        .tree li button:active,
        .tree li button:focus {
            text-decoration: none;
            color: #369;
            border: none;
            background: transparent;
            margin: 0px 0px 0px 0px;
            padding: 0px 0px 0px 0px;
            outline: 0;
        }


        #myUL {
            margin: 0;
            padding: 0;
        }

        .box {
            cursor: pointer;
            -webkit-user-select: none;
            /* Safari 3.1+ */
            -moz-user-select: none;
            /* Firefox 2+ */
            -ms-user-select: none;
            /* IE 10+ */
            user-select: none;
        }

        .box::before {
            content: "\2610";
            color: black;
            display: inline-block;
            margin-right: 6px;
        }

        .check-box::before {
            content: "\2611";
            color: dodgerblue;
        }

        .nested {
            display: none;
        }

        .active {
            display: block;
        }
    </style>
@endsection

@section('content')
    @include('errors.messages')

    <div class="kt-wizard-v4" id="kt_apps_user_add_user" data-ktwizard-state="step-first">
        <!--end: Form Wizard Nav -->
        <div class="kt-portlet">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v4__wrapper">

                        <!--begin: Form Wizard Form-->
                        <form class="kt-form kt-form--label-right" id="kt_form_1" method="post"
                            action="{{ route('postaddcategories') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <!--begin: Form Wizard Step 1-->
                            <div class="kt-wizard-v4__content" data-ktwizard-type="step-content"
                                data-ktwizard-state="current">
                                <div class="kt-portlet__head kt-portlet__head--lg" style="">
                                    <div class="kt-portlet__head-label">
                                        <h2 class="kt-portlet__head-title">{{ __('pages.add-new-category') }}</h2>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.language') }} <span
                                            style="color: red">*</span></label>
                                    <div class="col-lg-9 col-xl-9">
                                        <select class="form-control" name="lang">
                                            <option value="" selected> {{ __('pages.choose-language') }} </option>
                                            <option value="ar" selected="selected"> {{ __('pages.language-ar') }}
                                            </option>
                                            <option value="en"> {{ __('pages.language-en') }} </option>
                                        </select>

                                    </div>
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-wizard-v4__form">
                                        <div class="col-xl-12">
                                            <div class="kt-section__body">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">
                                                        {{ __('pages.category-name') }} <span
                                                            style="color: red">*</span></label>
                                                    <div class="col-lg-9 col-xl-9">
                                                        <input required class="form-control" name="name" type="text"
                                                            value="{{ old('name') }}">
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
        $(document).ready(function() {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    name: {
                        required: true,
                    },
                    lang: {
                        required: true,
                    },
                },

                messages: {
                    name: "{{ __('pages.enter_category_name') }}",

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

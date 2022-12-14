@extends('backend.layouts.app')

@section('style')
<link href="{{ asset('css/summernote.css') }}" rel="stylesheet" type="text/css" />
<style>
        .nav-pills, .nav-tabs {
            margin: 0;
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
                    <ul id="myTab" class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('services') }}">
                                <h5>{{ __('pages.services') }}</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog') }}">
                                <h5>{{ __('pages.blog') }}</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('site_setting') }}">
                                <h5>{{ __('pages.site_setting') }}</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pages') }}">
                                <h5>{{ __('pages.pages') }}</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact_messages') }}">
                                <h5>{{ __('pages.contact_messages') }}</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('testimonials') }}">
                                <h5>{{ __('pages.testimonials') }}</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active">
                                <h5>{{ __('pages.store-newsletter') }}</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('consultations') }}">
                                <h5>{{ __('pages.consultations') }}</h5>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!--begin::Form-->
            <form class="kt-form kt-form--label-right" id="kt_form_1" method="post" action="{{ route('postaddnewsletters') }}" enctype="multipart/form-data">
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
                        <label class="col-xl-3 col-lg-3 col-form-label">{{ __('pages.title') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input  class="form-control" id="kt_name" name="title" type="text" value="{{ old('title') }}">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.message') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea id="summernote" name="content"></textarea>
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

        $(document).ready(function () {
            $("#kt_form_1").validate({
                // define validation rules
                rules: {
                    title: {
                        required: true,
                    },
                    content: {
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

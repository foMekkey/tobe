@extends('backend.layouts.app')

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('pages.edit-service') }}
                </h3>
            </div>
        </div>

        <div class="kt-portlet__body">
            <form action="{{ route('postupdateservices',['id'=>$service->id]) }}" method="post" id="kt_form_1" enctype="multipart/form-data">
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
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.profile') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="kt-avatar kt-avatar--outline kt-avatar--circle" id="kt_apps_user_add_avatar">
                                <div class="kt-avatar__holder" id="imagePreview" style="background-image: url('{{ asset("uploads/".$service->image) }}');background-size: 100% 100%;"></div>
                                <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="{{ __('pages.change_image') }}">
                                    <i class="fa fa-pencil"></i>
                                    <input  type="file" name="image" id="imageUpload">
                                </label>
                                <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                                    <i class="fa fa-times"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.language') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <select class="form-control"  name="lang" >
                                <option value="ar" @if($service->lang == 'ar')selected @endif> {{ __('pages.language-ar') }} </option>
                                <option value="en" @if($service->lang == 'en')selected @endif> {{ __('pages.language-en') }} </option>
                            </select>

                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label"> {{ __('pages.service-name') }}     <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <input class="form-control" name="title" type="text" value="{{ ($service->title) ? $service->title  : old('title') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.desc') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea  class="form-control" name="desc" id="exampleTextarea" rows="3" spellcheck="false">{{ $service->desc }}</textarea>                                                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.content') }} <span style="color: red">*</span></label>
                        <div class="col-lg-9 col-xl-9">
                            <textarea id="summernote" name="content">{!! $service->content !!}</textarea>
                        </div>
                    </div>

                    <div class="kt-form__actions">
                        <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                            {{ __('pages.save') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
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
                    lang: {
                        required: true,
                    },
                    desc: {
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





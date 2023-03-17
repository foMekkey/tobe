@extends('backend.layouts.app')
@section('style')
    <style>
        .kt-widget5 .kt-widget5__item .kt-widget5__content:last-child {
            justify-content: right;
            text-align: right;
        }

        .kt-widget5__item {
            margin-bottom: -15px !important
        }

        .check {
            line-height: 1px
        }

        .note-editor img {
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
    @include('errors.messages')

    <div class="kt-portlet kt-portlet--height-fluid" style="direction: rtl">

        {{-- head --}}
        <div class="kt-portlet__head">

            <div class="kt-portlet__head-toolbar">
                <ul id="myTab" class="nav nav-pills nav-pills-sm nav-pills-label nav-pills-bold" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link">
                            <h5>{{ __('pages.services') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">
                            <h5>{{ __('pages.blog') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('site_setting') }}">
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
                        <a class="nav-link" href="{{ route('newsletters') }}">
                            <h5>{{ __('pages.store-newsletter') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('consultations') }}">
                            <h5>{{ __('pages.consultations') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faqs') }}">
                            <h5>{{ __('pages.faqs') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('e_wallets') }}">
                            <h5>{{ __('pages.e_wallets') }}</h5>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('banks') }}">
                            <h5>{{ __('pages.banks') }}</h5>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- body --}}
        <div class="kt-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="kt_widget5_tab1_content" aria-expanded="true">
                    <form action="{{ route('updateSiteSetting') }}" id="kt_form_1" method="post">
                        {{ csrf_field() }}

                        @foreach ($settings as $setting)
                            <div class="kt-widget5">
                                <div class="kt-widget5__item">
                                    <div class="kt-widget5__content">
                                        <div class="kt-widget5__section" style="width: 100%;">
                                            <div class="form-group row">
                                                <label
                                                    class="col-form-label col-md-2">{{ __('pages.site_settings.' . $setting->name) }}<span
                                                        style="color: red">*</span></label>
                                                <div
                                                    class="col-md-{{ $setting->type == 'textarea' || $setting->type == 'html' ? 10 : 5 }}">
                                                    @if ($setting->type == 'text' || $setting->type == 'number')
                                                        <input type="{{ $setting->type }}" value="{{ $setting->value }}"
                                                            name="{{ $setting->name }}" class="form-control" placeholder=""
                                                            required="">
                                                    @elseif($setting->type == 'textarea')
                                                        <textarea name="{{ $setting->name }}" class="form-control" rows="3" required="">{{ $setting->value }}</textarea>
                                                    @elseif($setting->type == 'html')
                                                        <textarea name="{{ $setting->name }}" class="summernote" required="">{{ $setting->value }}</textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <h5 style="border-bottom: 5px solid #ccc;margin-bottom: 25px"></h5>

                        {{-- ---------------------------- --}}
                        <div class="col-sm-2 text-center">
                            <button type="submit" class="btn btn-success btn-block">{{ __('pages.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('script')
    <script src="{{ asset('js/summernote.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            // configure your validation
            $("#kt_form_1").validate();

            $('.summernote').summernote({
                callbacks: {
                    onImageUpload: function(files) {
                        editor = $(this);
                        for (let i = 0; i < files.length; i++) {
                            $.upload(files[i], editor);
                        }
                    }
                },
                //                disableResizeEditor: true,
                height: 300
            });

            $.upload = function(file, editor) {
                let out = new FormData();
                out.append('folder', 'images');
                out.append('file', file, file.name);

                $.ajax({
                    method: 'POST',
                    url: '{{ url('upload') }}',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: out,
                    success: function(img) {
                        $(editor).summernote('insertImage', img);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus + " " + errorThrown);
                    }
                });
            };
        });
    </script>
@endsection

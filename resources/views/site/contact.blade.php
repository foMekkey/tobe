@extends('site.layouts.app')

@section('styles')
    <style>
        .alert {
            font-size: 20px;
        }
    </style>
@endsection

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.contact_us') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('site/contact') }}">{{ __('site.contact_us') }}</a></li>
            </ul>
        </div>
    </section>

    <section class="contact">
        <div class="container-fluid">
            <div class="row">
                <h1>{{ __('site.contact_us') }}</h1>
                <form id="add_contact_form">
                    <div id="add_contact-alert" class="alert alert-success" role="alert" style="display: none"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __('site.your_name') }}"
                                name="name">
                            <span class="fa fa-user"></span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="{{ __('site.your_email') }}"
                                name="email">
                            <span class="fa fa-envelope"></span>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <textarea class="form-control" placeholder="{{ __('site.message') }}" name="message"></textarea>
                            <span class="fa fa-pen"></span>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <div class="g-recaptcha" id="feedback-recaptcha"
                                data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p>
                            * {{ __('site.contact_agreement') }}
                        </p>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            @csrf
                            <input type="submit" id="add_contact" class="btn black_hover" value="{{ __('site.send') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('#add_contact_form').validate({
            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true
                },
                message: 'required'
            }
        });

        $("#add_contact_form").submit(function(event) {
            // Stop form from submitting normally
            event.preventDefault();

            if (!$(this).valid()) return false;

            $('#add_contact').prop("disabled", true);
            $('#add_contact').html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "{{ url('site/contact') }}",
                type: 'post',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        $('#add_contact-alert').removeClass('alert-danger');
                        $('#add_contact-alert').addClass('alert-success');
                        $('#add_contact-alert').text("{{ __('site.add_contact_success') }}");
                        $('#add_contact-alert').show();
                        $('#add_contact_form').trigger("reset");
                    } else {
                        $('#add_contact-alert').removeClass('alert-success');
                        $('#add_contact-alert').addClass('alert-danger');
                        $('#add_contact-alert').text("{{ __('site.add_contact_error') }}");
                        $('#add_contact-alert').show();
                    }

                    $('#add_contact').prop("disabled", false);
                    $('#add_contact').text("{{ __('site.send') }}");

                    $('html, body').animate({
                        scrollTop: $("#add_contact-alert").offset().top - 50
                    }, 1000);
                }
            });
        });
    </script>
@endsection

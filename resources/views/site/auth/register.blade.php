@extends('site.layouts.app')

@section('styles')
    <style>
        .login .login_content form .form-group span {
            top: 52px;
            bottom: initial;
        }

        .login .login_content form label.error {
            color: red;
            margin-bottom: 0;
            font-size: 16px;
        }

        .field-error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        #countdown-container {
            display: none;
            margin-top: 15px;
            text-align: center;
            font-size: 18px;
        }

        #countdown {
            font-weight: bold;
            color: #28a745;
        }
    </style>
@endsection

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.register') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('register') }}">{{ __('site.register') }}</a></li>
            </ul>
        </div>
    </section>

    <section class="login">
        <div class="container-fluid">
            <div class="login_content">
                <h3 class="mustHidden">{{ __('site.register') }}</h3>
                <h4 class="mustHidden">{{ __('site.welcome_please') }} <span>{{ __('site.fill_in_the_fields') }}</span></h4>
                <div id="alert-container"></div>
                <form action="{{ route('do-register') }}" method="post" id="registration_form">
                    <div class="form-group">
                        <label>{{ __('site.first_name') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('site.first_name') }}" name="f_name"
                            value="{{ old('f_name') }}">
                        <span class="fa fa-user"></span>
                        <div class="field-error" id="f_name-error"></div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.last_name') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('site.last_name') }}" name="l_name"
                            value="{{ old('l_name') }}">
                        <span class="fa fa-user"></span>
                        <div class="field-error" id="l_name-error"></div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.email') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('site.email') }}" name="email"
                            value="{{ old('email') }}">
                        <span class="fa fa-envelope"></span>
                        <div class="field-error" id="email-error"></div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.password') }}</label>
                        <input type="password" class="form-control" id="password" placeholder="{{ __('site.password') }}"
                            name="password">
                        <span class="fa fa-lock"></span>
                        <div class="field-error" id="password-error"></div>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.confirm_pass') }}</label>
                        <input type="password" class="form-control" placeholder="{{ __('site.confirm_pass') }}"
                            name="confirm_pass">
                        <span class="fa fa-lock"></span>
                        <div class="field-error" id="confirm_pass-error"></div>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        <div class="field-error" id="g-recaptcha-response-error"></div>
                    </div>
                    <div class="form-group">
                        <label class="checkbox">
                            <input type="checkbox" name="agree_terms">
                            <i>
                                {{ __('site.i_agree') }}
                                <a href="{{ url('site/page/terms_conditions') }}" data-target="#terms_conditions_modal"
                                    data-toggle="modal">{{ __('site.terms') }}</a>
                            </i>
                            <span class="checkmark"></span>
                        </label>
                        <div class="field-error" id="agree_terms-error"></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        {{ csrf_field() }}
                        <input type="submit" class="btn black_hover" value="{{ __('site.register') }}">
                        <h5 class="register">{{ __('site.have_an_account') }} <a
                                href="{{ route('login') }}">{{ __('site.login') }}</a></h5>
                    </div>
                </form>

                <div id="countdown-container">
                    <p>{{ __('site.registration_success') }}</p>
                    <p>{{ __('site.verification_email_sent') }}</p>
                    <p>{{ __('site.redirecting_in') }} <span id="countdown">20</span> {{ __('site.seconds') }}</p>
                </div>
            </div>
        </div>
        <div class="modal fade text-center" id="terms_conditions_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        $(document).ready(function() {
            $('#registration_form').on('submit', function(e) {
                e.preventDefault();

                // التحقق من صحة النموذج
                if (!$(this).valid()) {
                    return false;
                }

                // التحقق من reCAPTCHA
                if (grecaptcha.getResponse() == '') {
                    $('#g-recaptcha-response-error').html(
                        '{{ __('site.recaptcha_required') ?? 'يرجى التحقق من أنك لست روبوتًا' }}');
                    return false;
                }

                // مسح أخطاء سابقة
                $('.field-error').html('');

                // إرسال النموذج باستخدام AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success message with toastr
                            toastr.success(response.message ||
                                '{{ __('site.registration_success') }}');

                            // Show countdown
                            $('#registration_form').hide();
                            $('#countdown-container').show();

                            // Start countdown
                            let seconds = 10;
                            const countdownInterval = setInterval(function() {
                                seconds--;
                                $('#countdown').text(seconds);
                                $('.mustHidden').hide();
                                if (seconds <= 0) {
                                    clearInterval(countdownInterval);
                                    window.location.href =
                                        '{{ url('student/courses') }}';
                                }
                            }, 1000);
                        } else {
                            toastr.error(response.message ||
                                '{{ __('site.registration_failed') }}');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;

                            // Display validation errors under each field
                            $.each(errors, function(field, messages) {
                                const errorMsg = Array.isArray(messages) ? messages[0] :
                                    messages;
                                $(`#${field}-error`).html(errorMsg);
                            });

                            // Scroll to the first error
                            const firstError = $('.field-error').not(':empty').first();
                            if (firstError.length) {
                                $('html, body').animate({
                                    scrollTop: firstError.offset().top - 100
                                }, 500);
                            }
                        } else {
                            toastr.error('{{ __('site.server_error') }}');
                        }

                        // إعادة تعيين reCAPTCHA
                        grecaptcha.reset();
                    }
                });
                return false;
            });
        });
    </script>
@endsection

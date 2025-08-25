@extends('site.layouts.app')

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.resend_activation') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('resend-activation') }}">{{ __('site.resend_activation') }}</a></li>
            </ul>
        </div>
    </section>

    <section class="login">
        <div class="container-fluid">
            <div class="login_content">
                <h3>{{ __('site.resend_activation') }}</h3>
                <h4>{{ __('site.enter_email_to_resend') }}</h4>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('resend.activation.submit') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('site.email') }}</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                        <span class="fa fa-envelope"></span>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        @error('g-recaptcha-response')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn black_hover" value="{{ __('site.send') }}">
                        <h5 class="register">{{ __('site.back_to') }} <a
                                href="{{ route('login') }}">{{ __('site.login') }}</a></h5>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@extends('site.layouts.app')

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.forgot_password_message') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('forgotPassword') }}">{{ __('site.forgot_password_message') }}</a></li>
            </ul>
        </div>
    </section>
    <section class="login">
        <div class="container-fluid">
            <div class="login_content">
                <h3>{{ __('site.forgot_password_message') }}</h3>
                <form action="{{ route('password.email') }}" method="post">
                    {{csrf_field()}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-group">
                        <label>{{ __('site.email') }}</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus name="email" placeholder="{{ __('site.email') }}">
                        <span class="fa fa-envelope"></span>
                        @error('email')
                            <div class="invalid-feedback text-center text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="referrer_url" value="{{ Session::get('referrer_url') ?? '' }}" />
                        <input type="submit" class="btn black_hover" value="{{ __('site.forgot_password_message') }}">
                        <h5 class="register">{{ __('site.do_not_have_account') }} <a href="{{route('register')}}">{{ __('site.register_account') }}</a></h5>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

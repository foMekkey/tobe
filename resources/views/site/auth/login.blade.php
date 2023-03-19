@extends('site.layouts.app')

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.login') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('login') }}">{{ __('site.login') }}</a></li>
            </ul>
        </div>
    </section>

    <section class="login">
        <div class="container-fluid">
            <div class="login_content">
                <h3>{{ __('site.login') }}</h3>
                <h4>{{ __('site.welcome_please') }} <span>{{ __('site.login') }}</span></h4>
                <form action="{{ route('do-login') }}" method="post">
                    @error('login')
                        <div class="alert alert-danger">{{ $message ?? __('site.login_error') }}</div>
                    @enderror

                    <div class="form-group">
                        <label>{{ __('site.email') }}</label>
                        <input type="text" class="form-control" name="email" placeholder="{{ __('site.email') }}">
                        <span class="fa fa-envelope"></span>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.password') }}</label>
                        <input type="password" class="form-control" name="password"
                            placeholder="{{ __('site.password') }}">
                        <span class="fa fa-lock"></span>
                    </div>
                    <div class="form-group">
                        {{-- <label class="checkbox">
                            <input type="checkbox"><i>Auto save</i>
                            <span class="checkmark"></span>
                        </label> --}}
                        <a href="{{ url('forgot-your-password') }}" class="forgot_pw">{{ __('site.forgot_password') }}</a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        {{ csrf_field() }}
                        <input type="hidden" name="referrer_url" value="{{ Session::get('referrer_url') ?? '' }}" />
                        <input type="submit" class="btn black_hover" value="{{ __('site.login_submit') }}">
                        <h5 class="register">{{ __('site.do_not_have_account') }} <a
                                href="{{ route('register') }}">{{ __('site.register_account') }}</a></h5>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

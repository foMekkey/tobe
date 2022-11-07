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
    <!--
            sub_head
    -->
    <section class="login">
        <div class="container-fluid">
            <div class="login_content">
                <h3>{{ __('site.register') }}</h3>
                <h4>{{ __('site.welcome_please') }} <span>{{ __('site.fill_in_the_fields') }}</span></h4>
                <form action="{{route('do-register')}}" method="post" id="registration_form">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-styled-right alert-arrow-right text-center bounceIn" 
                        style="margin-bottom: 0;margin: 0 5px;border-radius: 20px;min-height: 85px;">
                            <button type="button" class="close pull-left" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;line-height: 53px;color: red;">×</span>
                            </button>
                            <ul style="margin-right: 10px; list-style: none">
                                @foreach ($errors->all() as $error)
                                    <li >{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>{{ __('site.first_name') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('site.first_name') }}" name="f_name" value="{{ old('f_name') }}">
                        <span class="fa fa-user"></span>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.last_name') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('site.last_name') }}" name="l_name" value="{{ old('l_name') }}">
                        <span class="fa fa-user"></span>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.email') }}</label>
                        <input type="text" class="form-control" placeholder="{{ __('site.email') }}" name="email" value="{{ old('email') }}">
                        <span class="fa fa-envelope"></span>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.password') }}</label>
                        <input type="password" class="form-control" id="password" placeholder="{{ __('site.password') }}" name="password">
                        <span class="fa fa-lock"></span>
                    </div>
                    <div class="form-group">
                        <label>{{ __('site.confirm_pass') }}</label>
                        <input type="password" class="form-control" placeholder="{{ __('site.confirm_pass') }}" name="confirm_pass">
                        <span class="fa fa-lock"></span>
                    </div>
                    <div class="form-group">
                        <label class="checkbox">
                            <input type="checkbox" name="agree_terms">
                            <i>
                                {{ __('site.i_agree') }}
                                <a href="{{ url('site/page/terms_conditions') }}" target="_blank">{{ __('site.terms') }}</a>
                            </i>
                            <span class="checkmark"></span>
                        </label>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        {{csrf_field()}}
                        <input type="submit" class="btn black_hover" value="{{ __('site.register') }}">
                        <h5 class="register">{{ __('site.have_an_account') }} <a href="{{route('login')}}">{{ __('site.login') }}</a></h5>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('#registration_form').validate({rules: {
            f_name: 'required',
            l_name: 'required',
            email: {required: true, email: true},
            password: {minlength:8},
            confirm_pass: {minlength:8, equalTo : "#password"},
            agree_terms: 'required'
        }});
    </script>
@endsection

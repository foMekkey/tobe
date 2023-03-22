@extends('site.layouts.app')
@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ $title }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('forgot-your-password') }}">{{ $title }}</a></li>
            </ul>
        </div>
    </section>

    <section class="login">
        <div class="container-fluid">
            <div class="login_content">
                <h3>{{ $title }}</h3>
                @if (\Session::has('error'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('error') !!}</li>
                        </ul>
                    </div>
                @endif

                @if (\Session::has('save'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! \Session::get('save') !!}</li>
                        </ul>
                    </div>
                @endif
                <form action="{{ url('forgot-your-password') }}" method="post" id="loginForm" class="main_form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label><i style="color: #FF7F00;">*</i>البريد الألكتروني</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                            placeholder="هنا يكتب البريد  الألكتروني " required>
                        <span class="fa fa-envelope"></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn" value="أستعادة">
                        <h5 class="register">ليس لديك حساب ؟<a href="{{ url('/register') }}">سجل حساب</a></h5>
                        <h5 class="register" style="margin-top: 15px;"><a href="{{ url('/login') }}"
                                style="color: #000;">تسجيل الدخول</a></h5>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!--<div class="snapchat">-->
    <!--    <h3>{{ $title }}</h3>-->
    <!--</div>-->



    <!--<section class="add_account sign">-->
    <!--    <div class="container-fluid">-->
    <!--        <div class="sub_title">-->
    <!--            <h1>{{ $title }}</h1>-->
    <!--        </div>-->


    <!--        <div class="sign_container">-->

    <!--            <form action="{{ url('forgot-your-password') }}" method="post" id="loginForm" class="main_form">-->
    <!--            {{ csrf_field() }}-->
    <!--                <div class="form-group">-->
    <!--                    <h3><span>*</span>البريد الألكتروني</h3>-->
    <!--                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="هنا يكتب البريد  الألكتروني " required>-->
    <!--                    <i class="fa fa-envelope"></i>-->
    <!--                </div>-->

    <!--                <div class="form-group">-->
    <!--                    <input type="submit" class="btn" value="أستعادة">-->
    <!--                    <h6 style="float: right;">ليس لديك حساب ؟<a href="{{ url('/signup') }}">سجل حساب</a></h6>-->
    <!--                    <h6 style="float: left;"><a href="{{ url('/login') }}" style="color: #000;">تسجيل الدخول</a></h6>-->
    <!--                    <div class="clearfix"></div>-->
    <!--                </div>-->
    <!--            </form>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->
@endsection

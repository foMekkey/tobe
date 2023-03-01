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
            <li><a href="{{ url('change_password') }}">{{ $title }}</a></li>
        </ul>
    </div>
</section>
    
<section class="login">
    <div class="container-fluid">
        <div class="login_content">
            <h3>{{ $title }}</h3>
            
            <form action="{{ url('change_password') }}" method="post" id="loginForm" class="main_form">
                {{ csrf_field() }}
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group">
                    <label><i style="color: #FF7F00;">*</i>كلمة المرور</label>
                    <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
                    <span class="fa fa-lock"></span>
                </div>

                <div class="form-group">
                    <label><i style="color: #FF7F00;">*</i>تأكيد كلمة المرور</label>
                    <input type="password" class="form-control" name="repassword" placeholder="تأكيد كلمة المرور" required>
                    <span class="fa fa-lock"></span>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" value="تغيير">
                    <h5 class="register">ليس لديك حساب ؟<a href="{{ url('/signup') }}">سجل حساب</a></h6>
                    <h5 class="register" style="margin-top: 15px;"><a href="{{ url('/login') }}" style="color: #000;">تسجيل الدخول</a></h6>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</section>



<!--
<div class="snapchat">
    <h3>{{ $title }}</h3>
</div>

<section class="add_account sign">
    <div class="container-fluid">
        <div class="sub_title">
            <h1>{{ $title }}</h1>
        </div>
        
        <div class="sign_container">
            <form action="{{ url('change_password') }}" method="post" id="loginForm" class="main_form">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
                <div class="form-group">
                    <h3><span>*</span>كلمة المرور</h3>
                    <input type="password" class="form-control" name="password" placeholder="كلمة المرور" required>
                    <i class="fa fa-lock"></i>
                </div>

                <div class="form-group">
                    <h3><span>*</span>تأكيد كلمة المرور</h3>
                    <input type="password" class="form-control" name="repassword" placeholder="تأكيد كلمة المرور" required>
                    <i class="fa fa-lock"></i>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" value="تغيير">
                    <h6 style="float: right;">ليس لديك حساب ؟<a href="{{ url('/signup') }}">سجل حساب</a></h6>
                    <h6 style="float: left;"><a href="{{ url('/login') }}" style="color: #000;">تسجيل الدخول</a></h6>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</section>
-->


@endsection

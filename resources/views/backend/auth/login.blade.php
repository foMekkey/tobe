<!DOCTYPE html>

<html lang="en" dir="rtl">

<!-- begin::Head -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <!--begin::Base Path (base relative path for assets of this page) -->
    <base href="../../../../">

    <!--end::Base Path -->
    
    <title>To Be | Login Page 2</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style type="text/css">
        @font-face{font-family: Cairo-Regular ; src: url({{ asset('admin/assets/custom/fonts/Cairo-Regular.ttf') }})}
        body{font-family: "Cairo-Regular" !important;}
        .kt-login.kt-login--v2 .kt-login__wrapper .kt-login__container .kt-form .form-control
        {
            color: #fff
        }
    </style>
    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Fonts -->

    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{ asset('admin/assets/css/demo1/pages/general/login/login-2.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('admin/assets/vendors/global/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/demo1/style.bundle.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset('admin/assets/css/demo1/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/demo1/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/demo1/skins/brand/dark.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/demo1/skins/aside/dark.css') }}" rel="stylesheet" type="text/css" />

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/media/logos/favicon.ico') }}" />
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root">
    <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url({{ asset('admin/assets/media//bg/bg-1.jpg') }});">
            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                <div class="kt-login__container">
                    <div class="kt-login__logo">
                        <a href="#">
                            <img src="{{ asset('admin/assets/media/logos/logo-4.png') }}">
                        </a>
                    </div>
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">{{ __('pages.login') }}</h3>
                        </div>
                        <form class="kt-form" action="{{route('do-login')}}" method="post">
                            {{csrf_field()}}
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="البريد الإلكتروني" name="email" autocomplete="off">
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="كلمة المرور" name="password">
                            </div>
                            <div class="row kt-login__extra">
                                <div class="col text-right">
                                    <label class="kt-checkbox">
                                        <input type="checkbox" name="remember">{{ __('pages.remember') }}
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col kt-align-right text-left">
                                    {{-- <a href="javascript:;" id="kt_login_forgot" class="kt-link kt-login__link">نسيت كلمة المرور</a> --}}
                                </div>
                            </div>
                            <div class="kt-login__actions">
                                <button id="kt_login_signin_submit" class="btn btn-pill kt-login__btn-primary">{{ __('pages.go') }}</button>
                            </div>
                        </form>
                    </div>



                    {{--<div class="kt-login__account">
                                <span class="kt-login__account-msg">
                                   {{ __('pages.not-have-account') }}
                                </span>&nbsp;&nbsp;
                        <a href="{{route('register')}}" id="kt_login_signup" class="kt-link kt-link--light kt-login__account-link">{{ __('pages.register') }}</a>
                    </div>--}}  

                    <hr>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ asset('assets/vendors/global/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/demo1/scripts.bundle.js') }}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/js/demo1/pages/login/login-general.js') }}" type="text/javascript"></script>

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>

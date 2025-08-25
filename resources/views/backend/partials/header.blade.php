<!DOCTYPE html>
<html lang="en" direction="rtl" style="direction: rtl;">

<head>
    <base href="../">
    <meta charset="utf-8" />
    <title>To Be | Dashboard</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <link href="{{ asset('admin/assets/vendors/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/demo4/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    @yield('style')

    <link rel="shortcut icon" href="{{ asset('admin/assets/media/logos/favicon.ico') }}" />
    <link href="{{ asset('admin/assets/custom/fonts/font-awesome-4.7.0/css/font-awesome.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/assets/custom/css/main.css') }}" rel="stylesheet" type="text/css" />
</head>

<body
    style="background-image: url({{ asset('site_assets/images/footer_bg.png') }}); background-position: center top; background-size: 100% 350px;"
    class="kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

    <!-- begin:: Header Mobile -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="{{ url('site') }}" class="mr-2">
                <img alt="Logo" src="{{ asset('admin/assets/media/logos/logo-4-dark-sm.png') }}" />
            </a>
            &nbsp;
            <span class="kt-header__topbar-welcome">مرحبا,</span>
            <span class="kt-header__topbar-username">
                @if (auth()->check())
                    {{ Auth::user()->user_name }}
                @endif
            </span>
        </div>
        <div class="kt-header-mobile__toolbar">
            {{-- <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button> --}}
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                <span class="kt-header__topbar-icon kt-pulse kt-pulse--light">
                    <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect id="bound" x="0" y="0" width="24" height="24" />
                            <path
                                d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z"
                                id="Combined-Shape" fill="#000000" opacity="0.3" />
                            <path
                                d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z"
                                id="Combined-Shape" fill="#000000" />
                        </g>
                    </svg>
                    @if (auth()->check())
                        @if (Auth::user()->notifications && isset(Auth::user()->notifications[0]) && !Auth::user()->notifications[0]->read_at)
                            <span class="kt-pulse__ring"></span>
                        @endif
                    @endif
                </span>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                <form>
                    <!--begin: Head -->
                    @if (auth()->check())
                        <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b"
                            style="background: #FF7F00">
                            <h3 class="kt-head__title">
                                {{ __('pages.notifications') }}
                                &nbsp;
                                <span
                                    class="btn btn-primary btn-sm btn-bold btn-font-md">{{ Auth::user()->notifications ? count(Auth::user()->notifications) : '' }}</span>
                            </h3>
                        </div>
                    @endif

                    <!--end: Head -->
                    <div class="tab-content">
                        <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                            <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true"
                                data-height="300" data-mobile-height="200">
                                @if (auth()->check())
                                    @foreach (Auth::user()->notifications as $notification)
                                        <a @if ($notification->type == 2) href="{{ $notification->getLink() }}" @endif
                                            class="kt-notification__item">
                                            <div class="kt-notification__item-details">
                                                <div class="kt-notification__item-title">
                                                    {{ $notification->message }}
                                                </div>
                                                <div class="kt-notification__item-time">
                                                    {{ Carbon\Carbon::parse($notification->datetime)->diffForHumans() }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
        </div>
    </div>

    <!-- end:: Header Mobile -->
    <div class="kt-grid kt-grid--hor kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

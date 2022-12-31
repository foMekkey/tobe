<!-- begin:: Header -->
<div id="kt_header" class="kt-header  kt-header--fixed " data-ktheader-minimize="on">
    <div class="kt-container">

        <!-- begin:: Brand -->
        <div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
            <a class="kt-header__brand-logo" href="{{ url('site') }}">
                <img alt="Logo" src="{{ url('admin/assets/media/logos/logo-4.png') }}" class="kt-header__brand-logo-default" />
                <img alt="Logo" src="{{ url('admin/assets/media/logos/logo-4-dark-sm.png') }}" class="kt-header__brand-logo-sticky" />
            </a>
        </div>

        <!-- end:: Brand -->

        <!-- begin: Header Menu -->
        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
        <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile kt-visible-mobile">
                <ul class="kt-menu__nav">
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
                              @if(Auth::check())
                                @foreach(Auth::user()->permissions as $value)
                                    <li class="kt-menu__item " aria-haspopup="true"><a href="{{route($value->permissions)}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">{{ __('pages.'.$value->permissions) }}</span></a></li>
                                @endforeach
                              @endif
                    </li>
                </ul>
            </div>
        </div>
        <!-- end: Header Menu -->

        <!-- begin:: Header Topbar -->
        <div class="kt-header__topbar kt-grid__item">
            <!--begin: Notifications -->
            <div class="kt-header__topbar-item dropdown">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                    <span class="kt-header__topbar-icon kt-pulse kt-pulse--light">
                        <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24" />
                                <path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" id="Combined-Shape" fill="#000000" opacity="0.3" />
                                <path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" id="Combined-Shape" fill="#000000" />
                            </g>
                        </svg>
                        @if(Auth::user()->notifications && isset(Auth::user()->notifications[0]) && !Auth::user()->notifications[0]->read_at)
                            <span class="kt-pulse__ring"></span>
                        @endif
                    </span>

                    {{-- <span class="kt-badge kt-badge--light"></span> --}}
                </div>
                <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">
                    <form>
                        <!--begin: Head -->
                        <div class="kt-head kt-head--skin-dark kt-head--fit-x kt-head--fit-b" style="background: #FF7F00">
                            <h3 class="kt-head__title">
                                {{ __('pages.notifications') }}
                                &nbsp;
                                <span class="btn btn-primary btn-sm btn-bold btn-font-md">{{ Auth::user()->notifications ? count(Auth::user()->notifications) : '' }}</span>
                            </h3>
                        </div>

                        <!--end: Head -->
                        <div class="tab-content">
                            <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                                    @foreach(Auth::user()->notifications as $notification)
                                        <a @if($notification->type == 2) href="{{ $notification->getLink() }}" @endif class="kt-notification__item">
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
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end: Notifications -->

            <!--end: Language bar -->

            <!--begin: User bar -->
            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                <div class="kt-header__topbar-wrapper" {{--data-toggle="dropdown"--}} data-offset="10px,0px">
                    <span class="kt-header__topbar-welcome">مرحبا,</span>
                    <span class="kt-header__topbar-username">{{Auth::user()->user_name}}</span>
                    <a href="{{route('logout')}}" class="kt-header__topbar-username"><i class="fa fa-sign-out fa-lg fa-flip-horizontal" aria-hidden="true"></i></a>
                    {{-- <span class="kt-header__topbar-icon"><b>S</b></span> --}}
                    <img alt="Pic" src="{{ url('admin/assets/media/users/300_21.jpg') }}" class="kt-hidden" />
                </div>
            </div>

            <!--end: User bar -->
        </div>

        <!-- end:: Header Topbar -->
    </div>
</div>

<!-- end:: Header -->

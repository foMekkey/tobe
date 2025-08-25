<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-header--fixed" data-ktheader-minimize="on">
    <div class="kt-container">

        <!-- begin:: Brand -->
        <div class="kt-header__brand kt-grid__item" id="kt_header_brand">
            <a class="kt-header__brand-logo" href="{{ url('site') }}">
                <img alt="Logo" src="{{ url('admin/assets/media/logos/logo-4.png') }}"
                    class="kt-header__brand-logo-default" />
                <img alt="Logo" src="{{ url('admin/assets/media/logos/logo-4-dark-sm.png') }}"
                    class="kt-header__brand-logo-sticky" />
            </a>
        </div>
        <!-- end:: Brand -->

        <!-- begin: Header Menu -->
        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                class="la la-close"></i></button>
        <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile kt-visible-mobile">
                <ul class="kt-menu__nav">
                    @if (Auth::check())
                        @foreach (Auth::user()->permissions as $value)
                            <li class="kt-menu__item" aria-haspopup="true">
                                <a href="{{ route($value->permissions) }}" class="kt-menu__link">
                                    <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                    <span class="kt-menu__link-text">{{ __('pages.' . $value->permissions) }}</span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <!-- end: Header Menu -->

        <!-- begin:: Header Topbar -->
        <div class="kt-header__topbar kt-grid__item">
            <!--begin: Notifications -->
            <div class="kt-header__topbar-item dropdown">
                <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px"
                    id="notifications-dropdown-toggle">
                    <div class="notification-bell-wrapper custom-tooltip" data-tooltip="الإشعارات">
                        <i class="fa fa-bell notification-bell-icon"></i>
                        @if (auth()->check() && Auth::user()->notifications)
                            @php
                                $unreadCount = Auth::user()
                                    ->notifications->filter(function ($notification) {
                                        return !$notification->read_at;
                                    })
                                    ->count();
                            @endphp

                            @if ($unreadCount > 0)
                                <span class="notification-badge"
                                    id="unread-notifications-count">{{ $unreadCount }}</span>
                            @endif
                        @endif
                    </div>
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
                                        class="btn btn-primary btn-sm btn-bold btn-font-md">{{ Auth::user()->notifications ? count(Auth::user()->notifications) : '0' }}</span>
                                </h3>
                            </div>
                        @endif

                        <!--end: Head -->
                        <div class="tab-content">
                            <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                                <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true"
                                    data-height="300" data-mobile-height="200">
                                    @if (auth()->check() && count(Auth::user()->notifications) > 0)
                                        @foreach (Auth::user()->notifications as $notification)
                                            <span
                                                @if ($notification->type == 2) data-href="{{ $notification->getLink() }}" @endif
                                                class="kt-notification__item {{ !$notification->read_at ? 'unread-notification' : '' }}"
                                                data-notification-id="{{ $notification->id }}"
                                                onclick="markNotificationAsRead({{ $notification->id }}, event)">
                                                <div class="kt-notification__item-details">
                                                    <div class="kt-notification__item-title">
                                                        {{ $notification->message }}
                                                    </div>
                                                    <div class="kt-notification__item-time">
                                                        {{ Carbon\Carbon::parse($notification->datetime)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </span>
                                        @endforeach
                                    @else
                                        <div class="kt-notification__item">
                                            <div class="kt-notification__item-details text-center">
                                                <div class="kt-notification__item-title">
                                                    لا توجد إشعارات جديدة
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end: Notifications -->

            <!--begin: User bar -->
            <div class="kt-header__topbar-item kt-header__topbar-item--user">
                <div class="kt-header__topbar-wrapper">
                    <div class="user-profile-container">
                        <!-- User Profile Image with Custom Tooltip -->
                        @if (auth()->check())
                            @if ((int) auth()->user()->role === 3)
                                <a href="{{ url('/student/edit') }}" class="user-profile-image custom-tooltip"
                                    data-tooltip="{{ Auth::user()->user_name }} - تعديل الملف الشخصي">
                                    @if (!empty(Auth::user()->image) && file_exists(public_path('uploads/' . Auth::user()->image)))
                                        <img alt="صورة المستخدم" src="{{ asset('uploads/' . Auth::user()->image) }}" />
                                    @else
                                        <img alt="صورة المستخدم"
                                            src="{{ url('admin/assets/media/users/300_21.jpg') }}" />
                                    @endif
                                </a>
                            @else
                                <a href="{{ url('/users/edit/') }}/{{ Auth::user()->id }}"
                                    class="user-profile-image custom-tooltip"
                                    data-tooltip="{{ Auth::user()->user_name }} - تعديل الملف الشخصي">
                                    @if (!empty(Auth::user()->image) && file_exists(public_path('uploads/' . Auth::user()->image)))
                                        <img alt="صورة المستخدم" src="{{ asset('uploads/' . Auth::user()->image) }}" />
                                    @else
                                        <img alt="صورة المستخدم"
                                            src="{{ url('admin/assets/media/users/300_21.jpg') }}" />
                                    @endif
                                </a>
                            @endif
                        @endif

                        <!-- Logout Button with Custom Tooltip -->
                        <a href="{{ route('logout') }}" class="logout-button custom-tooltip"
                            data-tooltip="تسجيل الخروج">
                            <i class="fa fa-sign-out fa-lg fa-flip-horizontal" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!--end: User bar -->
        </div>
        <!-- end:: Header Topbar -->

        <style>
            /* Existing styles... */

            /* Unread notification style */
            .unread-notification {
                background-color: rgba(93, 120, 255, 0.1);
                font-weight: bold;
            }

            .unread-notification:hover {
                background-color: rgba(93, 120, 255, 0.2);
            }
        </style>

        <!-- Instead of using a separate script tag, use document.addEventListener -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function markNotificationAsRead(notificationId, event) {
                    // Don't interfere with links
                    if (event.target.tagName.toLowerCase() === 'a' || event.target.closest('a')) {
                        return;
                    }

                    // Prevent the default action
                    event.preventDefault();

                    // Get the notification element
                    var notification = document.querySelector('[data-notification-id="' + notificationId + '"]');
                    var redirectUrl = notification ? notification.getAttribute('data-href') : null;

                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', '{{ url('mark-notification-as-read') }}/' + notificationId, true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            // Remove unread styling from this notification
                            if (notification) {
                                notification.classList.remove('unread-notification');
                            }

                            // Update the unread count
                            var unreadCountElement = document.getElementById('unread-notifications-count');
                            if (unreadCountElement) {
                                var unreadCount = parseInt(unreadCountElement.textContent);
                                if (unreadCount > 1) {
                                    unreadCountElement.textContent = unreadCount - 1;
                                } else {
                                    unreadCountElement.style.display = 'none';
                                }
                            }

                            // Redirect to the URL if available
                            if (redirectUrl) {
                                window.location.href = redirectUrl;
                            }
                        }
                    };
                    xhr.send();
                }

                // Make markNotificationAsRead available globally
                window.markNotificationAsRead = markNotificationAsRead;
            });
        </script>
    </div>
</div>
<!-- end:: Header -->

<style>
    /* User Profile Container */
    .user-profile-container {
        display: flex;
        align-items: center;
        height: 100%;
    }

    /* User Profile Image */
    .user-profile-image {
        margin: 0 10px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s;
    }

    .user-profile-image img {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ebedf2;
        transition: all 0.3s;
    }

    .user-profile-image:hover img {
        border-color: #5d78ff;
        transform: scale(1.05);
    }

    /* Logout Button */
    .logout-button {
        color: #74788d;
        font-size: 18px;
        transition: all 0.3s;
        margin-right: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .logout-button:hover {
        color: #ff0000;
        transform: scale(1.1);
    }

    /* Custom Tooltip */
    .custom-tooltip {
        position: relative;
    }

    .custom-tooltip:hover:after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #5d78ff;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 99999;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .custom-tooltip:hover:before {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border: 5px solid transparent;
        border-bottom-color: #5d78ff;
        z-index: 99999;
    }

    /* Ensure vertical alignment */
    .kt-header__topbar-wrapper {
        height: 100%;
        display: flex;
        align-items: center;
    }

    /* Notification Bell Styling */
    .notification-bell-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 0 10px;
        cursor: pointer;
    }

    .notification-bell-icon {
        font-size: 20px;
        color: #74788d;
        transition: all 0.3s;
    }

    .notification-bell-wrapper:hover .notification-bell-icon {
        color: #5d78ff;
        transform: scale(1.1);
    }

    .notification-badge {
        position: absolute;
        top: 10px;
        right: 5px;
        background-color: #ff0000;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Align all topbar items vertically */
    .kt-header__topbar-item {
        display: flex;
        align-items: center;
        height: 100%;
    }

    .kt-header__topbar-item .kt-header__topbar-wrapper {
        display: flex;
        align-items: center;
        height: 100%;
    }
</style>

<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
    <div class="kt-container kt-body  kt-grid kt-grid--ver" id="kt_body">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <!-- begin:: Subheader -->
            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                <section class="second_menu">
                    <ul class="list-inline ">
                        @if(Auth::check())
                          @if(Auth::user()->role == 1)
                            <li><a href="{{route('courses')}}"><div class="menu_block"><span class="fa fa-book"></span><h1>{{ __('pages.courses') }}</h1></div></a></li>
                            <li><a href="{{route('users')}}"><div class="menu_block"><span class="fa fa-user"></span><h1>{{ __('pages.users') }}</h1></div></a></li>
                            <li><a href="{{route('groups')}}"><div class="menu_block"><span class="fa fa-users"></span><h1>{{ __('pages.groups') }}</h1></div></a></li>
                            {{-- <li><a href="{{route('events')}}"><div class="menu_block"><span class="fa fa-history"></span><h1>{{ __('pages.events') }}</h1></div></a></li>
                            <li><a href="{{route('notifications')}}"><div class="menu_block"><span class="fa fa-bell-o"></span><h1>الاشعارات</h1></div></a></li> --}}
                            <li><a href="{{route('categories')}}"><div class="menu_block"><span class="fa fa-th"></span><h1>{{ __('pages.catogries') }}</h1></div></a></li>
                            <li><a href="{{route('permissions')}}"><div class="menu_block"><span class="fa fa-unlock-alt"></span><h1>{{ __('pages.permission') }}</h1></div></a></li>
                            <li><a href="{{route('setting')}}"><div class="menu_block"><span class="fa fa-sliders"></span><h1>{{ __('pages.main-setting') }}</h1></div></a></li>
                            <li><a href="{{route('services')}}"><div class="menu_block"><span class="fa fa-globe fa-3x"></span><h1>{{ __('pages.site_content') }}</h1></div></a></li>
                          @elseif(Auth::user()->role == 2)
                            <li><a href="{{route('TrainerCourses')}}"><div class="menu_block"><span class="fa fa-book"></span><h1>{{ __('pages.courses') }}</h1></div></a></li>
                            <li><a href="{{route('TrainerGroups')}}"><div class="menu_block"><span class="fa fa-users"></span><h1>{{ __('pages.groups') }}</h1></div></a></li>
                            <li><a href="{{route('TrainerMeeting')}}"><div class="menu_block"><span class="fas fa-headset"></span><h1>{{ __('pages.meetings') }}</h1></div></a></li>
                            <li><a href="{{route('TrainerEvents')}}"><div class="menu_block"><span class="fa fa-history"></span><h1>{{ __('pages.my_calendar') }}</h1></div></a></li>
                            <li><a href="{{route('TrainerDiscussions')}}"><div class="menu_block"><span class="fas fa-comment-dots"></span><h1>{{ __('pages.discussions') }}</h1></div></a></li>
                            <li><a href="{{route('TrainerMissions')}}"><div class="menu_block"><span class="fa fa-tasks"></span><h1>{{ __('pages.missions') }}</h1></div></a></li>
                            <li><a href="{{route('TrainerNotifications')}}"><div class="menu_block"><span class="fa fa-bell-o"></span><h1>الاشعارات</h1></div></a></li>
                          @elseif(Auth::user()->role == 3)
                            <li><a href="{{route('StudentCourses')}}"><div class="menu_block"><span class="fa fa-home"></span><h1>{{ __('pages.home') }}</h1></div></a></li>
                            <li><a href="{{route('StudentCatalog')}}"><div class="menu_block"><span class="fa fa-book"></span><h1>{{ __('pages.courses_catalog') }}</h1></div></a></li>
                            <li><a href="{{route('addgroupsStudent')}}"><div class="menu_block"><span class="fa fa-users"></span><h1>{{ __('pages.join-to-group') }}</h1></div></a></li>
                            <li><a href="{{route('StudentDiscussions')}}"><div class="menu_block"><span class="fas fa-comment-dots"></span><h1>{{ __('pages.discussions') }}</h1></div></a></li>
                            <li><a href="{{route('StudentEvents')}}"><div class="menu_block"><span class="fa fa-history"></span><h1>{{ __('pages.my_calendar') }}</h1></div></a></li>
                            <li><a href="{{route('StudentMissions')}}"><div class="menu_block"><span class="fa fa-tasks"></span><h1>{{ __('pages.missions') }}</h1></div></a></li>
                            <li><a href="{{url('site/consult')}}"><div class="menu_block"><span class="fa fa-support"></span><h1>{{ __('pages.consultation_request') }}</h1></div></a></li>
                          @endif
                        @endif
                    </ul>
                </section>
            </div>
            <!-- end:: Subheader -->

<style>
    #kt_subheader {
        padding-top: 5px !important;
        padding-bottom: 0 !important;
        height: auto;
    }
    .second_menu{
        padding: 10px 0;
        padding-top: 0;
        width: 100%;
    }
    .second_menu ul {
        display: flex;
        margin: 0 auto;
        width: 100%;
        text-align: center;
    }
    .second_menu ul li{
        flex: 1;
        float: right;
    }
    .second_menu ul li .menu_block span {
        font-size: 24px;
        color: #494b74;
        background-color: #f2f3f8;
        width: 60px;
        height: 60px;
        line-height: 60px;
        border-radius: 50px;
        margin-bottom: 10px;
        transition: all .3s;
    }
    .second_menu ul li .menu_block h1 {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
        transition: all .3s;
    }
    .second_menu ul li a:hover .menu_block span{
        box-shadow: 0 3px 10px rgba(73, 75, 116, .7);
    }
    .kt-head {
        padding: 10px;
    }
    .kt-head__title {
        padding-bottom: 10px;
    }
    
    /* New style */
    body {
        color: #222 !important;
    }
    a:hover {
        color: #FF7F00 !important;
    }
    .second_menu ul li a:hover .menu_block h1, a, .kt-widget5 .kt-widget5__item .kt-widget5__content .kt-widget5__title, 
    .kt-font-info, .kt-font-brand {
        color: #FF7F00 !important;
    }
    .btn-brand, .btn-success {
        background: #FF7F00 !important;
        border-color: #FF7F00 !important;
        color: #fff !important;
    }
    .btn-brand:hover, .btn-success:hover {
        background-color: #1F1A16 !important;
        border-color: #1F1A16 !important;
        color: #FF7F00 !important;
    }
    .kt-scrolltop {
        background: #FF7F00;
    }
    .dataTables_wrapper .pagination .page-item.active>.page-link {
        background: #FF7F00 !important;
        color: #fff !important;
    }
    .btn.btn-clean i {
        color: #FF7F00 !important;
    }
    .nav-tabs.nav-tabs-line.nav-tabs-line-brand a.nav-link.active, .nav-tabs.nav-tabs-line.nav-tabs-line-brand a.nav-link:hover, .nav-tabs.nav-tabs-line.nav-tabs-line-brand.nav.nav-tabs .nav-link.active, .nav-tabs.nav-tabs-line.nav-tabs-line-brand.nav.nav-tabs .nav-link:hover {
        border-color: #FF7F00 !important;
    }
    .alert.alert-success {
        background: #FF7F00 !important;
        border-color: #FF7F00 !important;
    }
    .tree li {
        color: #FF7F00 !important;
    }
    .kt-pulse.kt-pulse--light .kt-pulse__ring {
        border-color: #FF7F00 !important;
    }
    .kt-badge.kt-badge--success {
        background-color: #FF7F00 !important;
        color: #fff !important;
    } .nav-pills .nav-item .nav-link.active, .nav-pills .nav-item .nav-link.active:hover, .nav-pills .nav-item .nav-link:active {background-color: #FF7F00 !important;color: #fff !important;}
</style>
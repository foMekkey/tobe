<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
    <div class="kt-container kt-body  kt-grid kt-grid--ver" id="kt_body">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <!-- begin:: Subheader -->
            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                <section class="second_menu">
                    <ul class="list-inline ">
                        @if(Auth::check())
                            @foreach(Auth::user()->permissions as $value)
                                <li><a ><div class="menu_block"><span class="fa fa-book"></span><h1>{{ __('pages.'.$value->permission) }}</h1></div></a></li>
                            @endforeach
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
<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
    <div class="kt-container kt-body kt-grid kt-grid--ver" id="kt_body">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">
            <!-- begin:: Subheader -->
            <div class="kt-subheader kt-grid__item" id="kt_subheader">
                <section class="second_menu">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <ul class="menu-list">
                                    @if (Auth::check())
                                        @foreach (Auth::user()->permissions as $value)
                                            <li class="menu-item">
                                                <a href="{{ route($value->permissions) }}" class="menu-link">
                                                    <div class="menu-icon">
                                                        <span class="fa fa-book"></span>
                                                    </div>
                                                    <div class="menu-text">
                                                        <h1>{{ __('pages.' . $value->permissions) }}</h1>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- end:: Subheader -->

            <style>
                /* Reset and Base Styles */
                #kt_subheader {
                    padding: 10px 0 !important;
                    height: auto;
                    background-color: #1a1a27;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                }

                .second_menu {
                    width: 100%;
                }

                /* Menu List Styles */
                .menu-list {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    margin: 0;
                    padding: 0;
                    list-style: none;
                }

                .menu-item {
                    flex: 0 0 auto;
                    margin: 5px 10px;
                    transition: all 0.3s ease;
                }

                .menu-link {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-decoration: none;
                    padding: 10px;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                }

                .menu-link:hover {
                    background-color: rgba(255, 127, 0, 0.1);
                    transform: translateY(-3px);
                }

                /* Icon Styles */
                .menu-icon {
                    margin-bottom: 8px;
                }

                .menu-icon span {
                    font-size: 24px;
                    color: #FF7F00;
                    background-color: rgba(255, 127, 0, 0.1);
                    width: 60px;
                    height: 60px;
                    line-height: 60px;
                    border-radius: 50%;
                    display: inline-block;
                    text-align: center;
                    transition: all 0.3s ease;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }

                .menu-link:hover .menu-icon span {
                    background-color: #FF7F00;
                    color: #fff;
                    box-shadow: 0 5px 15px rgba(255, 127, 0, 0.3);
                    transform: scale(1.05);
                }

                /* Text Styles */
                .menu-text h1 {
                    font-size: 14px;
                    color: rgba(255, 255, 255, 0.85);
                    margin: 0;
                    font-weight: 500;
                    text-align: center;
                    transition: all 0.3s ease;
                }

                .menu-link:hover .menu-text h1 {
                    color: #FF7F00;
                }

                /* Responsive Adjustments */
                @media (max-width: 768px) {
                    .menu-item {
                        margin: 5px;
                    }

                    .menu-icon span {
                        width: 50px;
                        height: 50px;
                        line-height: 50px;
                        font-size: 20px;
                    }

                    .menu-text h1 {
                        font-size: 12px;
                    }
                }

                /* General Theme Styles */
                body {
                    color: #222 !important;
                }

                a:hover {
                    color: #FF7F00 !important;
                }

                .kt-widget5 .kt-widget5__item .kt-widget5__content .kt-widget5__title,
                .kt-font-info,
                .kt-font-brand {
                    color: #FF7F00 !important;
                }

                .btn-brand,
                .btn-success {
                    background: #FF7F00 !important;
                    border-color: #FF7F00 !important;
                    color: #fff !important;
                }

                .btn-brand:hover,
                .btn-success:hover {
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

                .nav-tabs.nav-tabs-line.nav-tabs-line-brand a.nav-link.active,
                .nav-tabs.nav-tabs-line.nav-tabs-line-brand a.nav-link:hover,
                .nav-tabs.nav-tabs-line.nav-tabs-line-brand.nav.nav-tabs .nav-link.active,
                .nav-tabs.nav-tabs-line.nav-tabs-line-brand.nav.nav-tabs .nav-link:hover {
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
                }

                .nav-pills .nav-item .nav-link.active,
                .nav-pills .nav-item .nav-link.active:hover,
                .nav-pills .nav-item .nav-link:active {
                    background-color: #FF7F00 !important;
                    color: #fff !important;
                }
            </style>

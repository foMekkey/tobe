@extends('backend.layouts.app')

@section('content')
    <div class="row">
        <div class="col-xl-6">

            <!--begin:: Widgets/Quick Stats-->
            <div class="row row-full-height">
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="kt-portlet kt-portlet--height-fluid-half kt-portlet--border-bottom-brand">
                        <div class="kt-portlet__body kt-portlet__body--fluid">
                            <div class="kt-widget26">
                                <div class="kt-widget26__content">
                                    <span class="kt-widget26__number">570</span>
                                    <span class="kt-widget26__desc">Total Sales</span>
                                </div>
                                <div class="kt-widget26__chart" style="height:100px; width: 230px;">
                                    <canvas id="kt_chart_quick_stats_1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-space-20"></div>
                    <div class="kt-portlet kt-portlet--height-fluid-half kt-portlet--border-bottom-danger">
                        <div class="kt-portlet__body kt-portlet__body--fluid">
                            <div class="kt-widget26">
                                <div class="kt-widget26__content">
                                    <span class="kt-widget26__number">640</span>
                                    <span class="kt-widget26__desc">Completed Transactions</span>
                                </div>
                                <div class="kt-widget26__chart" style="height:100px; width: 230px;">
                                    <canvas id="kt_chart_quick_stats_2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                    <div class="kt-portlet kt-portlet--height-fluid-half kt-portlet--border-bottom-success">
                        <div class="kt-portlet__body kt-portlet__body--fluid">
                            <div class="kt-widget26">
                                <div class="kt-widget26__content">
                                    <span class="kt-widget26__number">234+</span>
                                    <span class="kt-widget26__desc">Transactions</span>
                                </div>
                                <div class="kt-widget26__chart" style="height:100px; width: 230px;">
                                    <canvas id="kt_chart_quick_stats_3"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-space-20"></div>
                    <div class="kt-portlet kt-portlet--height-fluid-half kt-portlet--border-bottom-warning">
                        <div class="kt-portlet__body kt-portlet__body--fluid">
                            <div class="kt-widget26">
                                <div class="kt-widget26__content">
                                    <span class="kt-widget26__number">4.4M$</span>
                                    <span class="kt-widget26__desc">Paid Comissions</span>
                                </div>
                                <div class="kt-widget26__chart" style="height:100px; width: 230px;">
                                    <canvas id="kt_chart_quick_stats_4"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Quick Stats-->
        </div>
        <div class="col-xl-6">

            <!--begin:: Widgets/Order Statistics-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Order Statistics
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <a href="#" class="btn btn-label-brand btn-bold btn-sm dropdown-toggle" data-toggle="dropdown">
                            Export
                        </a>
                        <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right">

                            <!--begin::Nav-->
                            <ul class="kt-nav">
                                <li class="kt-nav__head">
                                    Export Options
                                    <i class="flaticon2-information" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more..."></i>
                                </li>
                                <li class="kt-nav__separator"></li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-drop"></i>
                                        <span class="kt-nav__link-text">Activity</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-calendar-8"></i>
                                        <span class="kt-nav__link-text">FAQ</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-link"></i>
                                        <span class="kt-nav__link-text">Settings</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="#" class="kt-nav__link">
                                        <i class="kt-nav__link-icon flaticon2-new-email"></i>
                                        <span class="kt-nav__link-text">Support</span>
                                        <span class="kt-nav__link-badge">
																			<span class="kt-badge kt-badge--success">5</span>
																		</span>
                                    </a>
                                </li>
                                <li class="kt-nav__separator"></li>
                                <li class="kt-nav__foot">
                                    <a class="btn btn-label-danger btn-bold btn-sm" href="#">Upgrade plan</a>
                                    <a class="btn btn-clean btn-bold btn-sm" href="#" data-toggle="kt-tooltip" data-placement="right" title="Click to learn more...">Learn more</a>
                                </li>
                            </ul>

                            <!--end::Nav-->
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body kt-portlet__body--fluid">
                    <div class="kt-widget12">
                        <div class="kt-widget12__content">
                            <div class="kt-widget12__item">
                                <div class="kt-widget12__info">
                                    <span class="kt-widget12__desc">Annual Taxes EMS</span>
                                    <span class="kt-widget12__value">$400,000</span>
                                </div>
                                <div class="kt-widget12__info">
                                    <span class="kt-widget12__desc">Finance Review Date</span>
                                    <span class="kt-widget12__value">July 24,2019</span>
                                </div>
                            </div>
                            <div class="kt-widget12__item">
                                <div class="kt-widget12__info">
                                    <span class="kt-widget12__desc">Avarage Revenue</span>
                                    <span class="kt-widget12__value">$60M</span>
                                </div>
                                <div class="kt-widget12__info">
                                    <span class="kt-widget12__desc">Revenue Margin</span>
                                    <div class="kt-widget12__progress">
                                        <div class="progress kt-progress--sm">
                                            <div class="progress-bar kt-bg-brand" role="progressbar" style="width: 40%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="kt-widget12__stat">
																			40%
																		</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget12__chart" style="height:250px;">
                            <canvas id="kt_chart_order_statistics"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!--end:: Widgets/Order Statistics-->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/assets/js/demo4/pages/dashboard.js') }}" type="text/javascript"></script>
@endsection
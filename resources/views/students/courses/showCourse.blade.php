@extends('backend.layouts.app')
@section('page-main-title', __('pages.courses'))

@section('content')

    <div class="message">

    </div>

    @include('errors.messages')

    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <h3 class="kt-portlet__head-title"></h3>
        </div>
        <div class="kt-portlet__body">
            <ul class="nav nav-pills nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#kt_tabs_5_1">    {{ $courseData->name }}</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="kt_tabs_5_1" role="tabpanel">
                    <div class="course_content">
                        <div class="course_content-heading">
                            <h1>{{ __('pages.course_content') }}</h1>
                            <div class="desc">
                                <h2>{{ __('pages.Total_learning') }}: <span>{{ $courses_count }} {{ __('pages.lessons') }} </span></h2>
                                <h2>Time: <span>{{ $courseData->duration }} {{ __('pages.weeks') }}</span></h2>
                            </div>
                        </div>

                                            @foreach($coursesLessons as $l)
                                                <div class="row">
                                                    @if($l->type == 1)
                                                        <a href="{{ route('showLessonStudent',['id'=>$l->id]) }}" class="course_link">
                                                            <div class="link_right">
                                                                <h2>
                                                                    <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                                                            <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#337ab7" fill-rule="nonzero" opacity="0.6"/>
                                                                            <rect id="Rectangle" fill="#000" x="6" y="12" width="9" height="1" rx="1"/>
                                                                            <rect id="Rectangle-Copy" fill="#000" x="6" y="16" width="5" height="1" rx="1"/>
                                                                        </g>
                                                                    </svg>
                                                                    <i class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{$l->number_lession}}</i>
                                                                    {{ $l->name }}
                                                                </h2>
                                                            </div><!-- link_right -->
                                                            {{-- <div class="link_left" style="display: inherit">
                                                                <form action="{{ route('showLessonStudent',['id'=>$l->id]) }}">
                                                                    <button class="btn">Preview</button>
                                                                </form>
                                                                <span>{{ $l->period }} min</span>
                                                            </div> --}}
                                                        </a><!-- link1 -->
                                                    @elseif($l->type ==2)
                                                        <a href="{{ route('showLessonStudent',['id'=>$l->id]) }}" class="course_link">
                                                            <div class="link_right">
                                                                <h2>
                                                                    <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                                            <path d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z" id="Path-10" fill="#337ab7" opacity="0.6"/>
                                                                        </g>
                                                                    </svg>
                                                                    <i class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{$l->number_lession}}</i>
                                                                    {{ $l->name }}
                                                                </h2>
                                                            </div><!-- link_right -->

                                                            {{-- <div class="link_left" style="display: inherit">
                                                                <button class="btn" id="download" onclick="window.open('{{ asset('uploads/'.$l->file) }}','_blank')">download</button>
                                                            </div> --}}
                                                        </a><!-- link3 -->
                                                    @else
                                                        <a href="{{ route('showLessonStudent',['id'=>$l->id]) }}" class="course_link">
                                                            <div class="link_right">
                                                                <h2>
                                                                    <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                            <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                                            <path d="M19,11 L20,11 C21.6568542,11 23,12.3431458 23,14 C23,15.6568542 21.6568542,17 20,17 L19,17 L19,20 C19,21.1045695 18.1045695,22 17,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,17 L5,17 C6.65685425,17 8,15.6568542 8,14 C8,12.3431458 6.65685425,11 5,11 L3,11 L3,8 C3,6.8954305 3.8954305,6 5,6 L8,6 L8,5 C8,3.34314575 9.34314575,2 11,2 C12.6568542,2 14,3.34314575 14,5 L14,6 L17,6 C18.1045695,6 19,6.8954305 19,8 L19,11 Z" id="Combined-Shape" fill="#337ab7" opacity="0.6"/>
                                                                        </g>
                                                                    </svg>
                                                                    <i class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{$l->number_lession}}</i>
                                                                    {{ $l->name }}
                                                                </h2>
                                                            </div><!-- link_right -->
                                                            {{-- <div class="link_left" style="display: inherit">
                                                                <span style="width: 80px;">{{ $l->numberQuestion }} questions</span>
                                                            </div> --}}
                                                        </a><!-- link6 -->
                                                    @endif
                                                </div><!-- row -->
                                            @endforeach
                                
                                {{--<li>--}}
                                {{--<div class="link"><h2>Section 2</h2><i class="fa fa-chevron-down"></i>--}}
                                {{--<h3>Perfect inelasticity and perfect</h3>--}}
                                {{--</div>--}}

                                {{--<div class="row">--}}
                                {{--<a href="#" class="course_link">--}}
                                {{--<div class="link_right">--}}
                                {{--<h2>--}}
                                {{--<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">--}}
                                {{--<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
                                {{--<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>--}}
                                {{--<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#337ab7" fill-rule="nonzero" opacity="0.6"/>--}}
                                {{--<rect id="Rectangle" fill="#000" x="6" y="12" width="9" height="1" rx="1"/>--}}
                                {{--<rect id="Rectangle-Copy" fill="#000" x="6" y="16" width="5" height="1" rx="1"/>--}}
                                {{--</g>--}}
                                {{--</svg>--}}
                                {{--<i>Lecture2.1</i>--}}
                                {{--Unit Objectives – Big Video--}}
                                {{--</h2>--}}
                                {{--</div><!-- link_right -->--}}
                                {{--<div class="link_left">--}}
                                {{--<button class="btn">Preview</button>--}}
                                {{--<span>30 min</span>--}}
                                {{--</div><!-- link_left -->--}}
                                {{--</a><!-- link1 -->--}}

                                {{--<a href="#" class="course_link">--}}
                                {{--<div class="link_right">--}}
                                {{--<h2>--}}
                                {{--<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">--}}
                                {{--<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
                                {{--<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>--}}
                                {{--<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#337ab7" fill-rule="nonzero" opacity="0.6"/>--}}
                                {{--<rect id="Rectangle" fill="#000" x="6" y="12" width="9" height="1" rx="1"/>--}}
                                {{--<rect id="Rectangle-Copy" fill="#000" x="6" y="16" width="5" height="1" rx="1"/>--}}
                                {{--</g>--}}
                                {{--</svg>--}}
                                {{--<i>Lecture2.2</i>--}}
                                {{--Setting Up Front-End Developer Environment--}}
                                {{--</h2>--}}
                                {{--</div><!-- link_right -->--}}
                                {{--<div class="link_left">--}}
                                {{--<button class="btn">Preview</button>--}}
                                {{--<span>30 min</span>--}}
                                {{--</div><!-- link_left -->--}}
                                {{--</a><!-- link2 -->--}}

                                {{--<a href="#" class="course_link">--}}
                                {{--<div class="link_right">--}}
                                {{--<h2>--}}
                                {{--<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">--}}
                                {{--<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
                                {{--<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>--}}
                                {{--<path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#337ab7" fill-rule="nonzero" opacity="0.6"/>--}}
                                {{--<rect id="Rectangle" fill="#000" x="6" y="12" width="9" height="1" rx="1"/>--}}
                                {{--<rect id="Rectangle-Copy" fill="#000" x="6" y="16" width="5" height="1" rx="1"/>--}}
                                {{--</g>--}}
                                {{--</svg>--}}
                                {{--<i>Lecture2.3</i>--}}
                                {{--Introduction to the Web--}}
                                {{--</h2>--}}
                                {{--</div><!-- link_right -->--}}
                                {{--<div class="link_left">--}}
                                {{--<button class="btn">Preview</button>--}}
                                {{--<span>30 min</span>--}}
                                {{--</div><!-- link_left -->--}}
                                {{--</a><!-- link3 -->--}}

                                {{--<a href="#" class="course_link">--}}
                                {{--<div class="link_right">--}}
                                {{--<h2>--}}
                                {{--<svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">--}}
                                {{--<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
                                {{--<rect id="bound" x="0" y="0" width="24" height="24"/>--}}
                                {{--<path d="M19,11 L20,11 C21.6568542,11 23,12.3431458 23,14 C23,15.6568542 21.6568542,17 20,17 L19,17 L19,20 C19,21.1045695 18.1045695,22 17,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,17 L5,17 C6.65685425,17 8,15.6568542 8,14 C8,12.3431458 6.65685425,11 5,11 L3,11 L3,8 C3,6.8954305 3.8954305,6 5,6 L8,6 L8,5 C8,3.34314575 9.34314575,2 11,2 C12.6568542,2 14,3.34314575 14,5 L14,6 L17,6 C18.1045695,6 19,6.8954305 19,8 L19,11 Z" id="Combined-Shape" fill="#337ab7" opacity="0.6"/>--}}
                                {{--</g>--}}
                                {{--</svg>--}}
                                {{--<i>Quiz2.1</i>--}}
                                {{--Final Quiz--}}
                                {{--</h2>--}}
                                {{--</div><!-- link_right -->--}}
                                {{--<div class="link_left">--}}
                                {{--<span>3 questions</span>--}}
                                {{--<span>10 min</span>--}}
                                {{--</div><!-- link_left -->--}}
                                {{--</a><!-- link4 -->--}}

                                {{--</div><!-- row -->--}}
                                {{--</li>--}}

                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!--end::Portlet-->
@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <!--begin::Page Vendors(used by this page) -->
    <script src="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <!--end::Page Vendors -->
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/datatables/advanced/column-rendering.js') }}" type="text/javascript"></script>
@endsection

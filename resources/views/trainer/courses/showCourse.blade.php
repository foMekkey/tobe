@extends('backend.layouts.app')
@section('style')


@endsection
@section('page-main-title', __('pages.courses'))

@section('content')

    <div class="message"></div>

    @include('errors.messages')

    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head kt-portlet__head--lg">

            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ $courseData->name }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <div class="dropdown dropdown-inline">
                            <a href="{{ route('addlessonsTrainer', ['id' => $courseData->id]) }}"
                                class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{ __('pages.add-new') }}
                            </a>
                        </div>
                        &nbsp;
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <ul class="nav nav-pills nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link tab-link active" data-toggle="tab" href="#kt_tabs_5_1">{{ __('pages.Content') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-link" data-toggle="tab"
                        href="#kt_tabs_5_2">{{ __('pages.users_and_progress') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('TrainerSurveys', $courseData->id) }}">{{ __('pages.surveys') }}</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#kt_tabs_5_3">{{ __('pages.rules_and_conduct') }}</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link disabled" data-toggle="tab" href="#kt_tabs_5_4">Disabled</a>
                </li> --}}
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="kt_tabs_5_1" role="tabpanel">
                    <div class="course_content">
                        <div class="course_content-heading">
                            <h1>{{ __('pages.course_content') }}</h1>
                            <div class="desc">
                                <h2>{{ __('pages.Total_learning') }}: <span>{{ $courses_count }} {{ __('pages.lessons') }}
                                    </span></h2>
                                <h2>{{ __('pages.time_period') }}: <span>{{ $courseData->duration }}
                                        {{ get_period_name($courseData->period_type) }}</span></h2>
                            </div>
                        </div>

                        @foreach ($coursesLessons as $l)
                            <div class="row">
                                @if ($l->type == 1)
                                    <a href="#" class="course_link">
                                        <div class="link_right">
                                            <h2>
                                                <svg xmlns="https://www.w3.org/2000/svg"
                                                    xmlns:xlink="https://www.w3.org/1999/xlink" width="30px"
                                                    height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                                                        <path
                                                            d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                                            id="Combined-Shape" fill="#337ab7" fill-rule="nonzero"
                                                            opacity="0.6" />
                                                        <rect id="Rectangle" fill="#000" x="6" y="12"
                                                            width="9" height="1" rx="1" />
                                                        <rect id="Rectangle-Copy" fill="#000" x="6"
                                                            y="16" width="5" height="1" rx="1" />
                                                    </g>
                                                </svg>
                                                <i
                                                    class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{ $l->number_lession }}</i>
                                                {{ $l->name }}
                                            </h2>
                                        </div><!-- link_right -->
                                        <div class="link_left" style="display: inherit">
                                            <form
                                                action="{{ route('getupdatelessonsTrainer', ['course_id' => $courseData->id, 'lesson_id' => $l->id]) }}">
                                                <button type="submit" class="btn">تعديل</button>
                                            </form>
                                            <form action="{{ route('showLessonTrainer', ['id' => $l->id]) }}">
                                                <button class="btn">Preview</button>
                                            </form>
                                            <span>{{ $l->period }} min</span>
                                        </div><!-- link_left -->
                                    </a><!-- link1 -->
                                @elseif($l->type == 2)
                                    <a href="#" class="course_link">
                                        <div class="link_right">
                                            <h2>
                                                <svg xmlns="https://www.w3.org/2000/svg"
                                                    xmlns:xlink="https://www.w3.org/1999/xlink" width="30px"
                                                    height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24"
                                                            height="24" />
                                                        <path
                                                            d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z"
                                                            id="Path-10" fill="#337ab7" opacity="0.6" />
                                                    </g>
                                                </svg>
                                                <i
                                                    class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{ $l->number_lession }}</i>
                                                {{ $l->name }}
                                            </h2>
                                        </div><!-- link_right -->

                                        <div class="link_left" style="display: inherit">
                                            <form
                                                action="{{ route('getupdatelessonsTrainer', ['course_id' => $courseData->id, 'lesson_id' => $l->id]) }}">
                                                <button type="submit" class="btn">تعديل</button>
                                            </form>
                                            <button class="btn" id="download">download</button>

                                            {{-- <a href="{{ asset('uploads/'.$l->file) }}" target="_blank" class="btnn">download</a> --}}

                                            {{-- <span>30 min</span> --}}
                                        </div><!-- link_left -->
                                    </a><!-- link3 -->
                                @else
                                    <a href="#" class="course_link">
                                        <div class="link_right">
                                            <h2>
                                                <svg xmlns="https://www.w3.org/2000/svg"
                                                    xmlns:xlink="https://www.w3.org/1999/xlink" width="25px"
                                                    height="25px" viewBox="0 0 24 24" version="1.1"
                                                    class="kt-svg-icon">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0"
                                                            width="24" height="24" />
                                                        <path
                                                            d="M19,11 L20,11 C21.6568542,11 23,12.3431458 23,14 C23,15.6568542 21.6568542,17 20,17 L19,17 L19,20 C19,21.1045695 18.1045695,22 17,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,17 L5,17 C6.65685425,17 8,15.6568542 8,14 C8,12.3431458 6.65685425,11 5,11 L3,11 L3,8 C3,6.8954305 3.8954305,6 5,6 L8,6 L8,5 C8,3.34314575 9.34314575,2 11,2 C12.6568542,2 14,3.34314575 14,5 L14,6 L17,6 C18.1045695,6 19,6.8954305 19,8 L19,11 Z"
                                                            id="Combined-Shape" fill="#337ab7" opacity="0.6" />
                                                    </g>
                                                </svg>
                                                <i
                                                    class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{ $l->number_lession }}</i>
                                                {{ $l->name }}
                                            </h2>
                                        </div><!-- link_right -->
                                        <div class="link_left" style="display: inherit">
                                            <form
                                                action="{{ route('getupdatelessonsTrainer', ['course_id' => $courseData->id, 'lesson_id' => $l->id]) }}">
                                                <button type="submit" class="btn">تعديل</button>
                                            </form>
                                            {{-- <button  class="btn">Preview</button>
                                            <span style="width: 80px;">{{ $l->numberQuestion }} questions</span> --}}
                                        </div><!-- link_left -->
                                    </a><!-- link6 -->
                                @endif
                            </div><!-- row -->
                        @endforeach

                        {{-- <li> --}}
                        {{-- <div class="link"><h2>Section 2</h2><i class="fa fa-chevron-down"></i> --}}
                        {{-- <h3>Perfect inelasticity and perfect</h3> --}}
                        {{-- </div> --}}

                        {{-- <div class="row"> --}}
                        {{-- <a href="#" class="course_link"> --}}
                        {{-- <div class="link_right"> --}}
                        {{-- <h2> --}}
                        {{-- <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"> --}}
                        {{-- <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> --}}
                        {{-- <polygon id="Shape" points="0 0 24 0 24 24 0 24"/> --}}
                        {{-- <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#337ab7" fill-rule="nonzero" opacity="0.6"/> --}}
                        {{-- <rect id="Rectangle" fill="#000" x="6" y="12" width="9" height="1" rx="1"/> --}}
                        {{-- <rect id="Rectangle-Copy" fill="#000" x="6" y="16" width="5" height="1" rx="1"/> --}}
                        {{-- </g> --}}
                        {{-- </svg> --}}
                        {{-- <i>Lecture2.1</i> --}}
                        {{-- Unit Objectives – Big Video --}}
                        {{-- </h2> --}}
                        {{-- </div><!-- link_right --> --}}
                        {{-- <div class="link_left"> --}}
                        {{-- <button class="btn">Preview</button> --}}
                        {{-- <span>30 min</span> --}}
                        {{-- </div><!-- link_left --> --}}
                        {{-- </a><!-- link1 --> --}}

                        {{-- <a href="#" class="course_link"> --}}
                        {{-- <div class="link_right"> --}}
                        {{-- <h2> --}}
                        {{-- <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"> --}}
                        {{-- <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> --}}
                        {{-- <polygon id="Shape" points="0 0 24 0 24 24 0 24"/> --}}
                        {{-- <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#337ab7" fill-rule="nonzero" opacity="0.6"/> --}}
                        {{-- <rect id="Rectangle" fill="#000" x="6" y="12" width="9" height="1" rx="1"/> --}}
                        {{-- <rect id="Rectangle-Copy" fill="#000" x="6" y="16" width="5" height="1" rx="1"/> --}}
                        {{-- </g> --}}
                        {{-- </svg> --}}
                        {{-- <i>Lecture2.2</i> --}}
                        {{-- Setting Up Front-End Developer Environment --}}
                        {{-- </h2> --}}
                        {{-- </div><!-- link_right --> --}}
                        {{-- <div class="link_left"> --}}
                        {{-- <button class="btn">Preview</button> --}}
                        {{-- <span>30 min</span> --}}
                        {{-- </div><!-- link_left --> --}}
                        {{-- </a><!-- link2 --> --}}

                        {{-- <a href="#" class="course_link"> --}}
                        {{-- <div class="link_right"> --}}
                        {{-- <h2> --}}
                        {{-- <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"> --}}
                        {{-- <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> --}}
                        {{-- <polygon id="Shape" points="0 0 24 0 24 24 0 24"/> --}}
                        {{-- <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" id="Combined-Shape" fill="#337ab7" fill-rule="nonzero" opacity="0.6"/> --}}
                        {{-- <rect id="Rectangle" fill="#000" x="6" y="12" width="9" height="1" rx="1"/> --}}
                        {{-- <rect id="Rectangle-Copy" fill="#000" x="6" y="16" width="5" height="1" rx="1"/> --}}
                        {{-- </g> --}}
                        {{-- </svg> --}}
                        {{-- <i>Lecture2.3</i> --}}
                        {{-- Introduction to the Web --}}
                        {{-- </h2> --}}
                        {{-- </div><!-- link_right --> --}}
                        {{-- <div class="link_left"> --}}
                        {{-- <button class="btn">Preview</button> --}}
                        {{-- <span>30 min</span> --}}
                        {{-- </div><!-- link_left --> --}}
                        {{-- </a><!-- link3 --> --}}

                        {{-- <a href="#" class="course_link"> --}}
                        {{-- <div class="link_right"> --}}
                        {{-- <h2> --}}
                        {{-- <svg xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon"> --}}
                        {{-- <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> --}}
                        {{-- <rect id="bound" x="0" y="0" width="24" height="24"/> --}}
                        {{-- <path d="M19,11 L20,11 C21.6568542,11 23,12.3431458 23,14 C23,15.6568542 21.6568542,17 20,17 L19,17 L19,20 C19,21.1045695 18.1045695,22 17,22 L5,22 C3.8954305,22 3,21.1045695 3,20 L3,17 L5,17 C6.65685425,17 8,15.6568542 8,14 C8,12.3431458 6.65685425,11 5,11 L3,11 L3,8 C3,6.8954305 3.8954305,6 5,6 L8,6 L8,5 C8,3.34314575 9.34314575,2 11,2 C12.6568542,2 14,3.34314575 14,5 L14,6 L17,6 C18.1045695,6 19,6.8954305 19,8 L19,11 Z" id="Combined-Shape" fill="#337ab7" opacity="0.6"/> --}}
                        {{-- </g> --}}
                        {{-- </svg> --}}
                        {{-- <i>Quiz2.1</i> --}}
                        {{-- Final Quiz --}}
                        {{-- </h2> --}}
                        {{-- </div><!-- link_right --> --}}
                        {{-- <div class="link_left"> --}}
                        {{-- <span>3 questions</span> --}}
                        {{-- <span>10 min</span> --}}
                        {{-- </div><!-- link_left --> --}}
                        {{-- </a><!-- link4 --> --}}

                        {{-- </div><!-- row --> --}}
                        {{-- </li> --}}

                    </div>
                </div>
                <div class="tab-pane" id="kt_tabs_5_2" role="tabpanel">
                    <div class="tab-pane" id="kt_apps_user_edit_tab_2" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                        </div>

                                        <table class="table table-striped- table-bordered table-hover table-checkable"
                                            id="userCourses">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>name</th>
                                                    <th>join</th>
                                                    <th>ended</th>
                                                    <th>type</th>
                                                    {{-- <th>Options</th> --}}
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="tab-pane" id="kt_tabs_5_3" role="tabpanel">
                    <form method="post" action="{{ route('postaddlessonsTramsTrainer',['id'=>$courseData->id]) }}" >
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="kt-form__content">
                                <div class="kt-alert m-alert--icon alert alert-danger kt-hidden" role="alert" id="kt_form_1_msg">
                                    <div class="kt-alert__icon">
                                        <i class="la la-warning"></i>
                                    </div>
                                    <div class="kt-alert__text">
                                        Oh snap! Change a few things up and try submitting again.
                                    </div>
                                    <div class="kt-alert__close">
                                        <button type="button" class="close" data-close="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.rules_of_traversal') }} <span style="color: red">*</span></label>
                                <div class="col-lg-9 col-xl-9">
                                    <select class="form-control"  name="rules_of_traversal" id="kt_level" >
                                        <option value="nothing" @if (isset($terms->rules_of_traversal) && $terms->rules_of_traversal == 'nothing') selected @endif>{{ __('pages.nothing') }}</option>
                                        <option value="Units-must-be-viewed"  @if (isset($terms->rules_of_traversal) && $terms->rules_of_traversal == 'Units-must-be-viewed') selected @endif>{{ __('pages.Units-must-be-viewed') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.rules_of_achievement') }} <span style="color: red">*</span></label>
                                <div class="col-lg-9 col-xl-9">
                                    <select class="form-control"  name="rules_of_achievement"  >
                                        <option value="finish-all-unit" @if (isset($terms->rules_of_achievement) && $terms->rules_of_achievement == 'finish-all-unit') selected @endif>{{ __('pages.finish-all-unit') }}</option>
                                        <option value="finish-some-unit" @if (isset($terms->rules_of_achievement) && $terms->rules_of_achievement == 'finish-some-unit') selected @endif>{{ __('pages.finish-some-unit') }}</option>
                                        <option value="percentage_units" @if (isset($terms->rules_of_achievement) && $terms->rules_of_achievement == 'percentage_units') selected @endif>{{ __('pages.percentage_units') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.learning_methods') }} <span style="color: red">*</span></label>
                                <div class="col-lg-9 col-xl-9">
                                    <input type="text"  name="learning_methods" class="form-control" value="{{ $terms->learning_methods ?? '' }}"  />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">  {{ __('pages.collect_result') }} <span style="color: red">*</span></label>
                                <div class="col-lg-9 col-xl-9">
                                    <select class="form-control"  name="collect_result"  >
                                        <option value="score_all" @if (isset($terms->collect_result) && $terms->collect_result == 'score_all') selected @endif>{{ __('pages.score_all') }}</option>
                                        <option value="score_tests" @if (isset($terms->collect_result) && $terms->collect_result == 'score_tests') selected @endif>{{ __('pages.score_tests') }}</option>
                                        <option value="score_specific" @if (isset($terms->collect_result) && $terms->collect_result == 'score_specific') selected @endif>{{ __('pages.score_specific') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="kt-form__actions">
                            <button class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u" type="submit" >
                                {{ __('pages.save') }}
                            </button>
                        </div>
                    </form>
                </div> --}}

                <div class="tab-pane" id="kt_tabs_5_4" role="tabpanel"></div>
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
    <script src="{{ asset('admin/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js">
    </script>
    <!--end::Page Vendors -->
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('admin/assets/js/demo1/pages/crud/datatables/advanced/column-rendering.js') }}"
        type="text/javascript"></script>
    <script>
        var courses = '{{ $courseData->id }}';
        $(function() {
            $('#userCourses').DataTable({
                processing: true,
                searching: true,
                serverSide: true,
                ajax: '{!! url('trainer/lessons/datatable-users-lesson/') !!}' + '/' + courses,
                "language": {
                    "url": "{{ asset('ar-datatable.json') }}"
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'title': '#'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name',
                        'title': 'الاسم'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        'title': 'تاريخ الالتحاق'
                    },
                    {
                        data: 'ended',
                        name: 'ended',
                        'title': 'تاريخ الانتهاء'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        'title': 'الدور'
                    },
                    // { data: 'options', name: 'options' ,'title':'العمليات' },
                ],
            });
        });
        if (window.location.hash) {
            var locHash = window.location.hash;
            if (locHash == '#kt_tabs_5_1' || locHash == '#kt_tabs_5_2') {
                $('.tab-pane').removeClass('active');
                $('.tab-link').removeClass('active');
                $(locHash).addClass('active');
                $('a[href="' + locHash + '"]').addClass('active');
            }
        }
    </script>

    {{-- <script> --}}
    {{-- $('#download').click(function(e) { --}}
    {{-- e.preventDefault();  //stop the browser from following --}}
    {{-- window.location.href = '{{ asset('uploads/'.$l->file) }}'; --}}
    {{-- }); --}}
    {{-- </script> --}}

@endsection

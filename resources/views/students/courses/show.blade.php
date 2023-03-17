@extends('backend.layouts.app')
@section('page-main-title', __('pages.courses'))

@section('style')
    <style>
        .course_subscribe {
            display: flex;
            padding: 30px 0;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-top: 1px solid rgba(112, 112, 112, .45);
            border-bottom: 1px solid rgba(112, 112, 112, .45);
            margin-bottom: 40px;
        }

        .course_subscribe .course_info:first-child {
            display: flex;
            align-items: center;
        }

        .course_subscribe img {
            float: left;
            margin-right: 15px;
        }

        .course_subscribe h4 {
            font-size: 16px;
            color: #AAAAAA;
            margin-top: 0;
        }

        .course_subscribe h3 {
            font-size: 16px;
            color: #000;
            margin: 0;
        }

        .course_subscribe img+div {
            float: left;
        }

        ul.rate li {
            font-size: 16px;
            color: #FF7F00;
            padding: 0;
        }

        .course_subscribe h6 {
            font-size: 26px;
            color: #FF7F00;
        }

        .course_subscribe .btn {
            border-radius: 4px;
            width: 180px;
        }

        .course_subscribe .course_info {
            margin: 10px 0;
        }
    </style>
@endsection

@section('content')

    <div class="message"></div>

    @include('errors.messages')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon2-line-chart"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ $courseData->name }}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="row">
                <div class="col-md-3 pull-right text-center">
                    <img class="img-fluid" src="{{ config('filesystems.disks.contabo.url') . '/' . $courseData->image }}"
                        alt="" style="border-radius: 4px;">
                    @if ($courseUser)
                        @foreach ($courseSurveys as $survey)
                            <a href="{{ route('showSurveysStudent', $survey->id) }}">
                                <img class="img-fluid"
                                    src="{{ asset('admin/assets') }}/{{ $survey->is_day_star ? 'day_star.jpg' : 'survey_icon.jpg' }}"
                                    style="margin-top: 10px;" />
                            </a>
                        @endforeach
                        @foreach ($courseCompletedSurveys as $survey)
                            <a href="{{ route('showSurveyResultsStudent', $survey->id) }}">
                                <img class="img-fluid" src="{{ asset('admin/assets/survey_results_icon.png') }}"
                                    style="margin-top: 10px;" />
                            </a>
                        @endforeach
                    @else
                        <a class="btn btn-brand btn-elevate btn-block join_course" href="#"
                            style="margin-top: 20px;">{{ __('pages.got_course') }}</a>
                    @endif
                </div>
                <div class="col-md-9 pull-right">
                    <div class="kt-widget5__content">
                        <div class="kt-widget5__section">
                            <div class="kt-widget5__info">
                                {{ $courseData->category->name ?? '' }}
                            </div>
                            <h2>{{ $courseData->name }}</h2>
                            <div class="course_subscribe">
                                <div class="course_info">
                                    <img src="{{ asset('site_assets') }}/images/graduated (1).png">
                                    <div style="margin-right: 5px;">
                                        <h4>المحاضر</h4>
                                        <h3>{{ ($courseData->user->f_name ?? '') . ' ' . ($courseData->user->l_name ?? '') }}
                                        </h3>
                                    </div>
                                </div>
                                <div class="course_info">
                                    <h4>تاريخ البدء</h4>
                                    <h3>{{ $courseData->start_date }}</h3>
                                </div>
                                <div class="course_info">
                                    <h4>تاريخ الإنتهاء</h4>
                                    <h3>{{ $courseData->end_date }}</h3>
                                </div>
                                <div class="course_info">
                                    <h6>$ {{ $courseData->price }}</h6>
                                </div>
                            </div>
                            {!! $courseData->content !!}
                            <br>
                        </div>
                    </div>
                    <div class="course_content" style="margin-top: 0">
                        <div class="course_content-heading">
                            <h1>{{ __('pages.course_content') }}</h1>
                        </div>

                        @foreach ($coursesLessons as $l)
                            <div class="row">
                                <a href="{{ route('showLessonStudent', ['id' => $l->id]) }}" class="course_link">
                                    <div class="link_right">
                                        <h2>
                                            @if (in_array($l->id, $completedLessons))
                                                <i class="fa fa-check fa-lg"></i>
                                            @else
                                                <i class="fa {{ $icons[$l->type] ?? $icons[0] }} fa-lg"></i>
                                            @endif
                                            <i
                                                class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{ $l->number_lession }}</i>
                                            {{ $l->name }}
                                        </h2>
                                    </div><!-- link_right -->
                                </a><!-- link1 -->
                            </div><!-- row -->
                        @endforeach
                    </div>
                    @if ($courseData->complete_rules)
                        <div class="course_content">
                            <div class="course_content-heading">
                                <h1>{{ __('pages.rules_of_achievement') }}</h1>
                            </div>
                            <div class="row">
                                <br>
                                <p>
                                    {!! $courseData->complete_rules !!}
                                </p>
                                <br>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--end::Portlet-->
@endsection

@section('script')
    <script>
        $('.join_course').click(function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('StudentCatalogJoinCourse') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': {{ $courseData->id }}
                },
                success: function(msg) {
                    location.reload();
                }
            });
        });
    </script>
@endsection

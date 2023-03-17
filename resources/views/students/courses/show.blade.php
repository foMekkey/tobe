@extends('backend.layouts.subscripe-app')
@section('page-main-title', __('pages.courses'))

@section('meta-tags')
    <meta name="keywords" content="{{ $course->tags }}">
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('site_assets') }}/css/star-rating-svg.css">
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

@section('content_header')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.courses') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('site/courses') }}">{{ __('site.courses') }}</a></li>
            </ul>
        </div>
    </section>
@endsection

@section('content')
    <section class="single_course">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="course_detail">
                        <img class="img-fluid"
                            src="{{ config('filesystems.disks.contabo.url') . '/' . $courseData->image }}" alt=""
                            style="border-radius: 4px;">
                        <h2>{{ $course->category->name ?? '' }}</h2>
                        <div class="course_subscribe">
                            <div class="course_info">
                                <img src="{{ asset('site_assets') }}/images/graduated (1).png">
                                <div>
                                    <h4>{{ __('site.the_lecturer') }}</h4>
                                    <h3>{{ ($course->user->f_name ?? '') . ' ' . ($course->user->l_name ?? '') }}</h3>
                                </div>
                            </div>
                            <div class="course_info">
                                <h4>{{ __('site.category') }}</h4>
                                <h3>{{ $course->category->name ?? '' }}</h3>
                            </div>
                            <div class="course_info">
                                <ul class="list-inline rate" style="display:inline-flex;">
                                    @for ($i = 1; $i < 6; $i++)
                                        @if ($i <= (int) $reviewsAvg)
                                            <li><span class="fas fa-star"></span></li>
                                        @else
                                            <li><span class="far fa-star"></span></li>
                                        @endif
                                    @endfor
                                </ul>
                                <h3>Reviews</h3>
                            </div>
                            <div class="course_info">
                                <h6>$ {{ $course->price }}</h6>
                            </div>
                            @if (!$courseUser)
                                <div class="course_info">
                                    <a href="javascript:void(0)"
                                        class="btn black_hover join_course">{{ __('site.subscribe') }}</a>
                                </div>
                            @endif
                        </div><!-- course_subscribe -->

                        <div class="serv_name">
                            <div class="left">
                                <h3>{{ $course->name }}</h3>
                                {!! $course->content !!}
                            </div>
                            <div class="right">
                                <div class="info_box">
                                    <h3>{{ __('site.course_information') }}</h3>
                                    <p>{{ __('site.beginning') }} :
                                        {{ \Carbon\Carbon::parse($course->start_date)->format('j/n/Y') }}</p>
                                    <p>{{ __('site.end') }} :
                                        {{ \Carbon\Carbon::parse($course->end_date)->format('j/n/Y') }}</p>
                                    <p>{{ __('site.num_of_hours') }} : {{ $course->duration }}</p>
                                    <p>{{ __('site.specific_conditions') }} : {{ __('site.none') }}</p>
                                </div>
                            </div>
                        </div><!-- serv_name -->

                        <div class="course_content" style="margin-top: 0">
                            <div class="course_content-heading">
                                <h1>{{ __('pages.course_content') }}</h1>
                            </div>

                            <div class="course_content-body">
                                @foreach ($coursesLessons as $l)
                                    <div class="row">
                                        <a href="{{ route('showLessonStudent', ['id' => $l->id]) }}" class="course_link">
                                            <div class="link_right">
                                                <h2>
                                                    @if (in_array($l->id, $completedLessons))
                                                        <i class="fa fa-check-square-o fa-lg"></i>
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
                        </div>
                        @if ($course->complete_rules)
                            <div class="course_content">
                                <div class="course_content-heading">
                                    <h1>{{ __('pages.rules_of_achievement') }}</h1>
                                </div>

                                <div class="course_content-body">
                                    <div class="row">
                                        <br>
                                        <p>
                                            {!! $course->complete_rules !!}
                                        </p>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="word" style="display: none;">
                            @if ($course->user->image)
                                <img src="{{ asset('uploads/' . $course->user->image) }}">
                            @endif
                            <div>
                                <span>,,</span>
                                <p>
                                    {{ $course->user->bio ?? '' }}
                                </p>
                                <h4>{{ ($course->user->f_name ?? '') . ' ' . ($course->user->l_name ?? '') }}</h4>
                            </div>
                        </div><!-- word -->

                        <div class="reviews">
                            <h3>{{ __('site.reviews') }}</h3>

                            <h1>{{ $reviewsCount }}<span> {{ __('site.rankings') }}</span> <br>
                                <i>{{ !count($reviewsGrouped) ? __('site.no_reviews') : '' }}</i>
                            </h1>

                            <ul style="">
                                <li>{{ $reviewsGrouped[5] ?? 0 }} <span></span>{{ __('site.stars') }} 5</li>
                                <li>{{ $reviewsGrouped[4] ?? 0 }} <span></span>{{ __('site.stars') }} 4</li>
                                <li>{{ $reviewsGrouped[3] ?? 0 }} <span></span>{{ __('site.stars') }} 3</li>
                                <li>{{ $reviewsGrouped[2] ?? 0 }} <span></span>{{ __('site.stars') }} 2</li>
                                <li>{{ $reviewsGrouped[1] ?? 0 }} <span></span>{{ __('site.stars') }} 1</li>
                            </ul>
                        </div><!-- reviews -->



                        <div class="add_comment">
                            <h3>{{ __('site.add_comment') }}</h3>
                            <div id="add_review-alert" class="alert alert-success" role="alert" style="display: none">
                            </div>
                            <form id="add_review_form">
                                <div class="form-group">
                                    <h4>{{ __('site.your_rating') }}*</h4>
                                    <div class="my-rating"></div>
                                    <input name="rate" id="add_review-rate" style="width: 0; border: none"
                                        tabindex="-1" />
                                </div>
                                <div class="form-group">
                                    <h4>{{ __('site.your_review') }}</h4>
                                    <textarea class="form-control" name="review"></textarea>
                                </div>
                                <div class="form-group">
                                    <h4>{{ __('site.your_name') }}*</h4>
                                    <input type="text" class="form-control" name="name" required="">
                                </div>
                                <div class="form-group">
                                    <h4>{{ __('site.your_email') }}*</h4>
                                    <input type="email" class="form-control" name="email" required="">
                                </div>
                                <div class="form-group">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}" />
                                    <input type="submit" class="btn black_hover btn-success" id="add_review"
                                        value="{{ __('site.send') }}">
                                </div>
                            </form>

                        </div><!-- add_comment -->

                    </div>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    @if ($courseUser)
                        @foreach ($courseSurveys as $survey)
                            <a href="{{ route('showSurveysStudent', $survey->id) }}">
                                <img class="img-fluid mb-3"
                                    src="{{ asset('admin/assets') }}/{{ $survey->is_day_star ? 'day_star.jpg' : 'survey_icon.jpg' }}" />
                            </a>
                        @endforeach
                        @foreach ($courseCompletedSurveys as $survey)
                            <a href="{{ route('showSurveyResultsStudent', $survey->id) }}">
                                <img class="img-fluid mb-3" src="{{ asset('admin/assets/survey_results_icon.png') }}" />
                            </a>
                        @endforeach
                    @endif

                    <div class="article_search">
                        <h1>{{ __('site.serach') }}</h1>
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control"
                                    placeholder="{{ __('site.enter_search_keyword') }}">
                                <span class="fa fa-search"></span>
                            </div>
                        </form>
                    </div><!-- article_search -->

                    <div class="categories">
                        <h1>{{ __('site.categories') }}</h1>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="{{ url('site/courses/category/' . $category->id) }}">{{ $category->name }}
                                        <span>{{ count($category->courses) }}</span></a></li>
                            @endforeach
                        </ul>
                    </div><!-- categories -->

                    {{-- <div class="book_now">
                        <h2>Book now</h2>
                        <h1>New course</h1>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <a href="#" class="btn black_hover">Sign Up</a>
                    </div><!-- book_now --> --}}

                    <div class="last_news">
                        <h1>{{ __('site.latest_courses') }}</h1>
                        @foreach ($latestCourses as $latestCourse)
                            <div class="news_item">
                                <a href="{{ url('site/course/' . $latestCourse->id) }}">
                                    <img src="{{ asset('uploads/' . $latestCourse->image) }}">
                                    <p>
                                        {{ $latestCourse->name }}
                                        <span>{{ \Carbon\Carbon::parse($latestCourse->start_date)->format('F j, Y') }}</span>
                                    </p>
                                </a>
                            </div>
                        @endforeach
                    </div><!-- last_news -->

                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('site_assets') }}/js/jquery.star-rating-svg.min.js"></script>
    <script>
        $(".my-rating").starRating({
            initialRating: 0,
            strokeColor: '#FF7F00',
            starShape: 'rounded',
            useFullStars: true,
            strokeWidth: 0,
            starSize: 20,
            disableAfterRate: false,
            callback: function(currentRating, $el) {
                $('#add_review-rate').val(currentRating);
                $('#add_review-rate').removeClass('error');
                $('#add_review-rate').closest('.form-group').find('label.error').remove();
            }
        });

        $('#add_review_form').validate({
            rules: {
                rate: 'required',
                name: 'required',
                email: {
                    required: true,
                    email: true
                },
                course_id: 'required'
            }
        });

        $("#add_review_form").submit(function(event) {
            // Stop form from submitting normally
            event.preventDefault();

            if (!$(this).valid()) return false;

            $('#add_review').prop("disabled", true);
            $('#add_review').html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            );

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "{{ url('site/course/store_review') }}",
                type: 'post',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        $('#add_review-alert').removeClass('alert-danger');
                        $('#add_review-alert').addClass('alert-success');
                        $('#add_review-alert').text("{{ __('site.add_review_success') }}");
                        $('#add_review-alert').show();
                        $('#add_review_form').trigger("reset");
                    } else {
                        $('#add_review-alert').removeClass('alert-success');
                        $('#add_review-alert').addClass('alert-danger');
                        $('#add_review-alert').text("{{ __('site.add_review_error') }}");
                        $('#add_review-alert').show();
                    }

                    $('#add_review').prop("disabled", false);
                    $('#add_review').text("{{ __('site.send') }}");

                    $('html, body').animate({
                        scrollTop: $("#add_review-alert").offset().top - 50
                    }, 1000);
                }
            });
        });


        $('.join_course').click(function(event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "{{ route('StudentCatalogJoinCourse') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': {{ $course->id }}
                },
                success: function(msg) {
                    location.reload();
                }
            });
        });
    </script>
@endsection

@extends('site.layouts.app')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('site_assets') }}/css/star-rating-svg.css">
    <style>
        .error {
            font-weight: normal;
            line-height: 20px;
            font-size: 20px;
        }
    </style>
@endsection

@section('content')
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
    
    <section class="single_course">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="course_detail">
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
                                <ul class="list-inline rate">
                                    @for($i=1; $i<6; $i++)
                                        @if($i <= (int)$reviewsAvg)
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
                            @if($course['status'] == 1)
                            <div class="course_info">
                                <a class="disabled btn black_hover">{{ __('site.subscribed') }}</a>
                            </div>
                            @elseif($course['status'] == 0)
                            <div class="course_info">
                                <a class="disabled btn black_hover">{{ __('site.pending') }}</a>
                            </div>
                            @else
                            <div class="course_info">
                                <a href="{{ url('student/courses/subscripe/')}}/{{$course->id}}" class="btn black_hover">{{ __('site.subscripe') }}</a>
                            </div>
                            @endif
                        </div><!-- course_subscribe -->
                        <img src="{{ asset("uploads/".$course->image) }}" class="main_img">
                        
                        <div class="serv_name">
                            <div class="left">
                                <h3>{{ $course->name }}</h3>
                                {!! $course->content !!}
                            </div>
                            <div class="right">
                                <div class="info_box">
                                    <h3>{{ __('site.course_information') }}</h3>
                                    <p>{{ __('site.beginning') }} : {{ \Carbon\Carbon::parse($course->start_date)->format('j/n/Y') }}</p>
                                    <p>{{ __('site.end') }} : {{ \Carbon\Carbon::parse($course->end_date)->format('j/n/Y') }}</p>
                                    <p>{{ __('site.num_of_hours') }} : {{ $course->duration }}</p>
                                    <p>{{ __('site.specific_conditions') }} : {{ __('site.none') }}</p>
                                </div>
                            </div>
                        </div><!-- serv_name -->

                        <div class="word">
                            @if($course->user->image)
                                <img src="{{ asset("uploads/".$course->user->image) }}">
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
                            
                            <h1>{{ $reviewsCount }}<span>{{ __('site.rankings') }}</span><i>{{ !count($reviewsGrouped) ? __('site.no_reviews') : '' }}</i></h1>
                            
                            <ul>
                                <li>{{ $reviewsGrouped[5] ?? 0 }} <span></span>{{ __('site.stars') }} 5</li>
                                <li>{{ $reviewsGrouped[4] ?? 0 }} <span></span>{{ __('site.stars') }} 4</li>
                                <li>{{ $reviewsGrouped[3] ?? 0 }} <span></span>{{ __('site.stars') }} 3</li>
                                <li>{{ $reviewsGrouped[2] ?? 0 }} <span></span>{{ __('site.stars') }} 2</li>
                                <li>{{ $reviewsGrouped[1] ?? 0 }} <span></span>{{ __('site.stars') }} 1</li>
                            </ul>
                        </div><!-- reviews -->
                        
                        <div class="comments">
                            
                            <h3>التعليقات</h3>
                            @foreach($reviews as $review)
                            <div class="block">
                                <div class="comm_title">
                                    <h1>{{$review->name}}</h1>
                                    <h2>التقييم: <span>{{$review->rate}}</span></h2>
                                </div>
                                <div class="comm_body">
                                    <p>
                                        {{$review->review}}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            
                            
                        </div><!-- comments -->

                        <div class="add_comment">
                            <h3>{{ __('site.add_comment') }}</h3>
                            <div id="add_review-alert" class="alert alert-success" role="alert" style="display: none"></div>
                            <form id="add_review_form">
                                <div class="form-group">
                                    <h4>{{ __('site.your_rating') }}*</h4>
                                    <div class="my-rating"></div>
                                    <input name="rate" id="add_review-rate" style="width: 0; border: none" tabindex="-1" />
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
                                    <input type="submit" class="btn black_hover" id="add_review" value="{{ __('site.send') }}">
                                </div>
                            </form>

                        </div><!-- add_comment -->

                    </div>
                </div>

                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="article_search">
                        <h1>{{ __('site.serach') }}</h1>
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="{{ __('site.enter_search_keyword') }}">
                                <span class="fa fa-search"></span>
                            </div>
                        </form>
                    </div><!-- article_search -->
                    
                    <div class="categories crs_inf">
                        <h1>{{ $course->category->name ?? '' }}</h1>
                        <ul>
                            <li>
                                <span>{{ __('site.the_lecturer') }} : </span>
                                {{ ($course->user->f_name ?? '') . ' ' . ($course->user->l_name ?? '') }}
                            </li>
                            <li>
                                <span>{{ __('site.category') }} : </span>
                                {{ $course->category->name ?? '' }}
                            </li>
                            <li>
                                <span>المراجعات : </span>
                                <ul class="list-inline rate">
                                    @for($i=1; $i<6; $i++)
                                        @if($i <= (int)$reviewsAvg)
                                            <li><span class="fas fa-star"></span></li>
                                        @else
                                            <li><span class="far fa-star"></span></li>
                                        @endif
                                    @endfor
                                </ul>
                            </li>
                            <li>
                                <span>السعر : </span>
                                <span class="price">$ {{ $course->price }}</span>
                            </li>
                            <li>
                                @if($course['status'] == 1)
                                    <div class="course_info">
                                        <a class="disabled btn black_hover">{{ __('site.subscribed') }}</a>
                                    </div>
                                @elseif($course['status'] == 0)
                                    <div class="course_info">
                                        <a class="disabled btn black_hover">{{ __('site.pending') }}</a>
                                    </div>
                                @else
                                    <div class="course_info">
                                        <a href="{{ url('student/courses/subscripe/')}}/{{$course->id}}" class="btn black_hover">{{ __('site.subscripe') }}</a>
                                    </div>
                                @endif
                            </li>
                        </ul>
                    </div><!-- categories -->
                    
                    <div class="book_now">
    					<h2>احجز الان</h2>
    					<h1>كورس جديد</h1>
    					<p> هو ببساطة نص شكلي (بمعنى أن الغاية هي الشكل وليس المحتوى) ويُستخدم في صناعات المطابع ودور النشر. كان لوريم إيبسوم ولايزال المعيار </p>
    					<a href="#" class="btn black_hover">تسجيل</a>
    				</div><!-- book_now -->
                    
                    <div class="categories">
                        <h1>{{ __('site.categories') }}</h1>
                        <ul>
                            @foreach($categories as $category)
                                <li><a href="{{ url('site/courses/category/' . $category->id) }}">{{ $category->name }} <span>{{ count($category->courses) }}</span></a></li>
                            @endforeach
                        </ul>
                    </div><!-- categories -->

                    <div class="last_news">
                        <h1>{{ __('site.latest_courses') }}</h1>
                        @foreach($latestCourses as $latestCourse)
                        <div class="news_item">
                            <a href="{{ url('site/course/' . $latestCourse->id) }}">
                                <img src="{{ asset("uploads/".$latestCourse->image) }}">
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

@section('scripts')
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
            callback: function(currentRating, $el){
                $('#add_review-rate').val(currentRating);
                $('#add_review-rate').removeClass('error');
                $('#add_review-rate').closest('.form-group').find('label.error').remove();
            }
        });
        
        $('#add_review_form').validate({rules: {
            rate: 'required',
            name: 'required',
            email: {required: true, email: true},
            course_id: 'required'
        }});
    
        $("#add_review_form").submit(function (event) {
            // Stop form from submitting normally
            event.preventDefault();

            if(!$(this).valid()) return false;
            
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
                success: function (data) {
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
    </script>
@endsection
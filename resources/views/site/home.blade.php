@extends('site.layouts.app')

@section('content')
    <section class="slider">
        <img src="{{ asset('site_assets') }}/images/slider_bg.png" class="slider_img">
        <img src="{{ asset('site_assets') }}/images/slider_shape.png" class="slider_shape">

        <div class="container-fluid">
            <div class="row">
                {!! $settings['slider_' . app()->getLocale()] !!}
            </div>
        </div>
    </section>
    <!-- end-slider -->
    <section class="about">
        <div class="container-fluid">
            <div class="row">
                {!! $settings['about_' . app()->getLocale()] !!}
            </div>
        </div>
    </section>
    <!-- end-about  -->
    <section class="sections">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="section_block wow bounceIn" data-wow-duration=".5s" data-wow-delay="0.5s">
                        <div class="pie-wrapper progress-45 style-2">
                            <div class="pie">
                                <div class="left-side half-circle"></div>
                                <div class="right-side half-circle"></div>
                            </div>
                        </div>
                        <div class="img_container">
                            <img src="{{ asset('site_assets') }}/images/knowledge1.png" class="icon1">
                            <img src="{{ asset('site_assets') }}/images/knowledge2.png" class="icon2">
                        </div>
                        <h3>{{ __('site.the_trainees') }}</h3>
                        <p class="aaa">{{ $settings['trainees_count'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="section_block wow bounceIn" data-wow-duration=".5s" data-wow-delay="0.5s">
                        <div class="pie-wrapper progress-45 style-2">
                            <div class="pie">
                                <div class="left-side half-circle"></div>
                                <div class="right-side half-circle"></div>
                            </div>
                        </div>
                        <div class="img_container">
                            <img src="{{ asset('site_assets') }}/images/knowledge1.png" class="icon1">
                            <img src="{{ asset('site_assets') }}/images/knowledge2.png" class="icon2">
                        </div>
                        <h3>{{ __('pages.certificates_count') }}</h3>
                        <p class="aaa">{{ $settings['certificates_count'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="section_block wow bounceIn" data-wow-duration=".5s" data-wow-delay="0.75s">
                        <div class="pie-wrapper progress-45 style-2">
                            <div class="pie">
                                <div class="left-side half-circle"></div>
                                <div class="right-side half-circle"></div>
                            </div>
                        </div>
                        <div class="img_container">
                            <img src="{{ asset('site_assets') }}/images/workshop1.png" class="icon1">
                            <img src="{{ asset('site_assets') }}/images/workshop2.png" class="icon2">
                        </div>
                        <h3>{{ __('site.training_hours') }}</h3>
                        <p class="aaa">{{ $settings['training_hours_count'] }}</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="section_block wow bounceIn" data-wow-duration=".5s" data-wow-delay="1s">
                        <div class="pie-wrapper progress-45 style-2">
                            <div class="pie">
                                <div class="left-side half-circle"></div>
                                <div class="right-side half-circle"></div>
                            </div>
                        </div>
                        <div class="img_container">
                            <img src="{{ asset('site_assets') }}/images/course1.png" class="icon1">
                            <img src="{{ asset('site_assets') }}/images/course2.png" class="icon2">
                        </div>
                        <h3>{{ __('site.courses') }}</h3>
                        <p class="aaa">{{ $settings['courses_count'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end_sections -->

    @if (count($services))
        <section class="services">
            <div class="container-fluid">
                <div class="row">
                    <div class="main_title">
                        <h3>{{ __('site.what_we_do') }}</h3>
                        <h1>{{ __('site.main_services') }}</h1>
                    </div>

                    <div id="service_slider">
                        @foreach ($services as $service)
                            <div class="item">
                                <div class="service_block">
                                    <div class="service_block-hover"></div>
                                    <img src="{{ asset('uploads/' . $service->image) }}">
                                    <h1>{{ $service->title }}</h1>
                                    <p>{{ $service->desc }}</p>
                                    <a href="{{ url('site/service/' . $service->id) }}">{{ __('site.read_more') }} <i
                                            class="fas fa-long-arrow-alt-{{ __('site.right') }}"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- end-services -->
    @endif

    <section class="advice">
        <div class="container-fluid">
            <div class="row">
                <div class="content">
                    <img src="{{ asset('site_assets') }}/images/advice_logo.png">
                    <h1>{{ __('site.contact_intro') }}</h1>
                    <a href="#" class="btn">{{ __('site.ask_for_advice') }} <i
                            class="fas fa-long-arrow-alt-{{ __('site.right') }}"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- end-advice -->

    @if (count($courses))
        <section class="courses">
            <div class="main_title">
                <h3>{{ __('site.case_studies') }}</h3>
                <h1>{{ __('site.next_courses') }}</h1>
            </div>

            <div id="courses_slider">
                @foreach ($courses as $course)
                    <div class="item">
                        <div class="course_block">
                            <a href="{{ url('site/course/' . $course->id) }}">
                                <img src="{{ config('filesystems.disks.contabo.url') . '/' . $course->image }}"
                                    class="main_img">
                                <div class="text">
                                    <div class="img_container">
                                        <img src="{{ asset('site_assets') }}/images/logo.png" class="icon1">
                                        <img src="{{ asset('site_assets') }}/images/logo.png" class="icon2">
                                    </div>
                                    <h1>{{ $course->name }}</h1>
                                    <p>{{ $course->desc }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- end-courses -->
    @endif

    @if (count($testimonials))
        <section class="client">
            <div class="container-fluid">
                <div class="row">
                    <div class="main_title">
                        <h3>{{ __('site.testimonials') }}</h3>
                        <h1>{{ __('site.what_client_saying') }}</h1>
                    </div>

                    <div id="client_slider">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="client_block">
                                    <div class="info">
                                        <img src="{{ asset('uploads/' . $testimonial->user->image) }}">
                                        <div class="text">
                                            <h3>{{ $testimonial->user->f_name . ' ' . $testimonial->user->l_name }}</h3>
                                            <h4>{{ $testimonial->user->type_label ?? '' }}</h4>
                                        </div>
                                    </div>
                                    <p>
                                        {{ $testimonial->message }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- end-client -->
    @endif

    <section class="connect">
        <div class="connect_bg">
            <div class="overlay_img"></div>
            <img src="{{ asset('site_assets') }}/images/connect_bg.png">
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="main_title">
                    <h3>{{ __('site.we_can_hear_you') }}</h3>
                    <h1>{{ __('site.request_direct_advice') }}</h1>
                    <p>
                        {{ __('site.consultation_intro') }}
                    </p>
                </div>

                <a href="{{ url('site/consult') }}" class="btn">{{ __('site.request_consultation') }}&nbsp;<i
                        class="fas fa-long-arrow-alt-{{ __('site.right') }}"></i></a>
            </div>
        </div>
    </section>
    <!-- end-connect -->

    @if (count($blog))
        <section class="blog">
            <div class="container-fluid">
                <div class="row">
                    <div class="main_title">
                        <div>
                            <h3>{{ __('site.news_and_updates') }}</h3>
                            <h1>{{ __('site.latest_from_blog') }}</h1>
                        </div>
                        <p>{{ __('site.blog_intro') }}</p>
                    </div>

                    @foreach ($blog as $singleBlog)
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="blog_block wow fadeIn" data-wow-duration=".5s" data-wow-delay="0.25s">
                                <a href="{{ url('site/blog/' . $singleBlog->id) }}">
                                    <img src="{{ config('filesystems.disks.contabo.url') . '/' . $singleBlog->image }}">
                                    <h3 class="date">{{ \Carbon\Carbon::parse($singleBlog->date)->format('M j, Y') }}
                                    </h3>
                                    <div class="blog_info">
                                        <ul class="list-inline">
                                            <li><i class="fas fa-user"></i>{{ __('site.by') }}
                                                {{ $singleBlog->created_by }}</li>
                                        </ul>
                                        <h1>{{ $singleBlog->title }}</h1>
                                        <a href="{{ url('site/blog/' . $singleBlog->id) }}">{{ __('site.read_more') }} <i
                                                class="fas fa-long-arrow-alt-{{ __('site.right') }}"></i></a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- end-blog -->
    @endif
@endsection

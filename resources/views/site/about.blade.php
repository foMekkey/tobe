@extends('site.layouts.app')

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.know_about_us') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('site/about') }}">{{ __('site.know_about_us') }}</a></li>
            </ul>
        </div>
    </section>
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
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="section_block wow bounceIn" data-wow-duration=".5s" data-wow-delay="0.25s">
                        <div class="pie-wrapper progress-45 style-2">
                            <div class="pie">
                                <div class="left-side half-circle"></div>
                                <div class="right-side half-circle"></div>
                            </div>
                        </div>
                        <div class="img_container">
                            <img src="{{ asset('site_assets') }}/images/medal1.png" class="icon1">
                            <img src="{{ asset('site_assets') }}/images/medal2.png" class="icon2">
                        </div>
                        <h3>{{ __('site.certificates') }}</h3>
                        <p class="aaa">{{ $settings['certificates_count'] }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
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
                <div class="col-md-3 col-sm-6 col-xs-12">
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
                <div class="col-md-3 col-sm-6 col-xs-12">
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
    
    @if(count($testimonials))
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
                                <img src="{{ asset("uploads/".$testimonial->user->image) }}">
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
@endsection

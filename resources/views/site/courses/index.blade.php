@extends('site.layouts.app')

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

    <section class="courses course_page">
        <div class="container-fluid">
            <div class="row">
                <div class="main_title">
                    <h3>{{ __('site.case_studies') }}</h3>
                    <h1>{{ __('site.next_courses') }}</h1>
                </div>

                @foreach ($courses as $course)
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="course_block">
                        <a href="{{ url('site/course/' . $course->id) }}">
                            <img src="{{ config("filesystems.disks.contabo.url").'/'.$course->image }}" class="main_img">
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

            {{ $courses->links() }}
        </div>
    </section>
@endsection

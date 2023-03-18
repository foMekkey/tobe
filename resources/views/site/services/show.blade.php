@extends('site.layouts.app')

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.our_services') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('site/services') }}">{{ __('site.services') }}</a></li>
            </ul>
        </div>
    </section>

    <section class="single_service">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="serv_name">
                        <img src="{{ asset('uploads/' . $service->image) }}">
                        <h3>{{ $service->title }}</h3>
                        {!! $service->content !!}
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="other_services">
                        <h1>خدمات أخرى</h1>
                        <ul>
                            @foreach ($latestServices as $latestService)
                                <li><a href="{{ url('site/service/' . $latestService->id) }}"><img
                                            src="{{ asset('uploads/' . $latestService->image) }}"
                                            width="29">{{ $latestService->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

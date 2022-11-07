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
    
    <section class="main_service">
        <div class="container-fluid">
            <div class="row">
                <div class="main_title">
                    <h3>{{ __('site.what_we_do') }}</h3>
                    <h1>{{ __('site.main_services') }}</h1>
                </div>
                
                @foreach ($services as $service)
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="myService">
                        <div class="img_container">
                            <img src="{{ asset("uploads/".$service->image) }}">
                            <div class="overlay"></div>
                        </div>
                        <div class="services_title">
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->desc }}</p>
                            <a href="{{ url('site/service/' . $service->id) }}">{{ __('site.read_more') }} <i class="fas fa-long-arrow-alt-{{ __('site.right') }}"></i></a>
                        </div>
                    </div>
                </div><!-- col-md-4 -->
                @endforeach
            </div>

            {{ $services->links() }}
        </div>
    </section>
@endsection

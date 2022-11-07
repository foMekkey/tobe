@extends('site.layouts.app')

@section('styles')
<style>
    ul li {
        font-size: 22px;
        line-height: 40px;
        color: #474747;
        font-family: "Bahij_Light";
        margin-bottom: 10px;
    }
    .serv_name h3 {
        font-size: 40px;
        line-height: 60px;
        color: #000;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.discover') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="#">{{ __('site.discover') }}</a></li>
            </ul>
        </div>
    </section>
    <section style="padding: 50px 70px;">
        <div class="serv_name">
            <h3>{{ __('site.discover') }}</h3>
            <ul>
                <li>
                    <a href="#">{{ __('site.individuals_services') }}</a>
                    <ul class="pr-3">
                        @foreach ($settings['individuals_services'] as $pageLink)
                            <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a href="#">{{ __('site.companies_services') }}</a>
                    <ul>
                        @foreach ($settings['companies_services'] as $pageLink)
                            <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @foreach ($settings['discover_pages'] as $pageLink)
                    <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                @endforeach
            </ul>	
        </div>
    </section>
@endsection

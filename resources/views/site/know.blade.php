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
                <h1>{{ __('site.know') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="#">{{ __('site.know') }}</a></li>
            </ul>
        </div>
    </section>
    <section style="padding: 50px 70px;">
        <div class="serv_name">
            <h3>{{ __('site.know') }}</h3>
            <ul>
                @foreach ($settings['know_pages'] as $pageLink)
                    <li><a href="{{ url('site/page') . '/' . $pageLink->key }}">{{ $pageLink->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </section>
@endsection

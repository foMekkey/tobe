@extends('site.layouts.app')

@section('content')
    @if(@$key != 'terms_conditions')
        <section class="sub_head">
            <div class="container-fluid">
                <div class="sub_title">
                    <h1>{{ $page->title }}</h1>
                    <h3>{{ __('site.blog_slugan') }}</h3>
                </div>
                <ul class="list-inline">
                    <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                    <li><a href="#">{{ $page->title }}</a></li>
                </ul>
            </div>
        </section>
    @endif
    <section class="single_service">
        <div class="container-fluid">
            <div class="serv_name">
                <h3>{{ $page->title }}</h3>
                    {!! $page->content !!}
            </div>
        </div>
    </section>
@endsection
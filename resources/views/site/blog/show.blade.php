@extends('site.layouts.app')

@section('content')
    <section class="sub_head">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.article_page') }}</h1>
                <h3>{{ __('site.blog_slugan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ url('site/blog') }}">{{ __('site.blog') }}</a></li>
            </ul>
        </div>
    </section>
    <section class="article">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="article_text">
                        <img src="{{ config('filesystems.disks.contabo.url') . '/' . $blog->image }}">
                        <ul class="list-inline detail">
                            <li><span class="fa fa-user"></span>{{ __('site.by') }} {{ $blog->created_by }}</li>
                        </ul>
                        <h3>{{ $blog->title }}</h3>
                        {!! $blog->content !!}
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
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

                    @if (count($latestNews))
                        <div class="last_news">
                            <h1>{{ __('site.latest_news') }}</h1>
                            @foreach ($latestNews as $oneNews)
                                <div class="news_item">
                                    <a href="{{ url('site/blog/' . $oneNews->id) }}">
                                        <img src="{{ config('filesystems.disks.contabo.url') . '/' . $oneNews->image }}">
                                        <p>
                                            {{ $oneNews->title }}
                                            <span>{{ \Carbon\Carbon::parse($oneNews->date)->format('F j, Y') }}</span>
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div><!-- last_news -->
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

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
                                <h3 class="date">{{ \Carbon\Carbon::parse($singleBlog->date)->format('M j, Y') }}</h3>
                                <div class="blog_info">
                                    <ul class="list-inline">
                                        <li><i class="fas fa-user"></i>{{ __('site.by') }} {{ $singleBlog->created_by }}
                                        </li>
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

            {{ $blog->links() }}
        </div>
    </section>
@endsection

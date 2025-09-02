@extends('site.layouts.app')

@section('styles')
    <link href="{{ asset('site_assets/css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="inner_banner">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ __('site.communities') }}</h1>
                <h3>{{ __('site.communities_slogan') }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="#">{{ __('site.communities') }}</a></li>
            </ul>
        </div>
    </section>

    <section class="communities-page">
        <div class="container">
            <div class="communities-header">
                <h1>مجتمعات التعلم والتواصل</h1>
                <p>انضم إلى مجتمعاتنا التعليمية للتفاعل مع المدربين والمتدربين ومشاركة الخبرات والمعرفة</p>
            </div>

            @if (count($courseCommunities) > 0)
                <div class="communities-section">
                    <div class="communities-section-header">
                        <h2>مجتمعات الدورات</h2>
                    </div>
                    <div class="communities-grid">
                        @foreach ($courseCommunities as $community)
                            <div class="community-card">
                                <div class="community-card-header">
                                    <h3>{{ $community->name }}</h3>
                                </div>
                                <div class="community-card-body">
                                    <p>{{ $community->description }}</p>
                                </div>
                                <div class="community-card-footer">
                                    <div class="community-stats">
                                        <div class="community-stat">
                                            <i class="fa fa-users"></i>
                                            <span>{{ $community->course->users->count() }} متدرب</span>
                                        </div>
                                        <div class="community-stat">
                                            <i class="fa fa-comment"></i>
                                            <span>{{ $community->posts->count() }} منشور</span>
                                        </div>
                                    </div>
                                    <div class="community-actions">
                                        <a href="{{ route('community.show', $community->id) }}"
                                            class="community-action primary">
                                            عرض المجتمع
                                        </a>
                                        <a href="{{ route('community.chat', $community->id) }}"
                                            class="community-action secondary">
                                            الدردشة
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (count($cohortCommunities) > 0)
                <div class="communities-section">
                    <div class="communities-section-header">
                        <h2>مجتمعات الأفواج</h2>
                    </div>
                    <div class="communities-grid">
                        @foreach ($cohortCommunities as $community)
                            <div class="community-card">
                                <div class="community-card-header">
                                    <h3>{{ $community->name }}</h3>
                                </div>
                                <div class="community-card-body">
                                    <p>{{ $community->description }}</p>
                                </div>
                                <div class="community-card-footer">
                                    <div class="community-stats">
                                        <div class="community-stat">
                                            <i class="fa fa-users"></i>
                                            <span>{{ $community->cohort->trainees->count() }} متدرب</span>
                                        </div>
                                        <div class="community-stat">
                                            <i class="fa fa-comment"></i>
                                            <span>{{ $community->posts->count() }} منشور</span>
                                        </div>
                                    </div>
                                    <div class="community-actions">
                                        <a href="{{ route('community.show', $community->id) }}"
                                            class="community-action primary">
                                            عرض المجتمع
                                        </a>
                                        <a href="{{ route('community.chat', $community->id) }}"
                                            class="community-action secondary">
                                            الدردشة
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (count($courseCommunities) == 0 && count($cohortCommunities) == 0)
                <div class="alert alert-info text-center">
                    <h4>لا توجد مجتمعات متاحة حالياً</h4>
                    <p>يرجى التسجيل في إحدى الدورات للانضمام إلى مجتمعاتنا التعليمية</p>
                    <a href="{{ url('site/courses') }}" class="btn btn-primary mt-3">استعرض الدورات المتاحة</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('site_assets/js/community.js') }}"></script>
@endsection

@extends('site.layouts.app')

@section('styles')
    <link href="{{ asset('site_assets/css/custom.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <section class="inner_banner">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>الدردشة المباشرة - {{ $community->name }}</h1>
                <h3>تواصل مع المدربين والمتدربين في الوقت الحقيقي</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ route('community.index') }}">{{ __('site.communities') }}</a></li>
                <li><a href="{{ route('community.show', $community->id) }}">{{ $community->name }}</a></li>
                <li><a href="#">الدردشة المباشرة</a></li>
            </ul>
        </div>
    </section>

    <section class="chat-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="chat-container" data-community-id="{{ $community->id }}"
                        data-user-id="{{ Auth::id() }}">
                        <div class="chat-header">
                            <div class="chat-header-info">
                                <h3>{{ $community->name }}</h3>
                                <p>
                                    <span class="online-users-count">{{ $onlineUsersCount }}</span> متصل الآن
                                </p>
                            </div>
                            <div class="chat-header-actions">
                                <a href="{{ route('community.show', $community->id) }}" class="btn btn-sm btn-default">
                                    <i class="fa fa-arrow-left"></i> العودة للمجتمع
                                </a>
                            </div>
                        </div>

                        <div class="chat-messages">
                            @foreach ($messages as $message)
                                <div class="chat-message {{ $message->user_id == Auth::id() ? 'sent' : 'received' }}"
                                    data-message-id="{{ $message->id }}">
                                    <div class="message-avatar">
                                        @if (!empty($message->user->image) && file_exists(public_path('uploads/' . $message->user->image)))
                                            <img src="{{ asset('uploads/' . $message->user->image) }}"
                                                alt="{{ $message->user->user_name }}">
                                        @else
                                            <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                alt="{{ $message->user->user_name }}">
                                        @endif
                                    </div>
                                    <div class="message-content">
                                        <div class="message-header">
                                            <span class="message-username">{{ $message->user->user_name }}</span>
                                            <span class="message-time">{{ $message->created_at->format('h:i A') }}</span>
                                        </div>
                                        <div class="message-text">{{ $message->content }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="chat-input">
                            <textarea id="message-input" placeholder="اكتب رسالتك هنا..."></textarea>
                            <button id="send-message">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>

                    <div class="chat-sidebar">
                        <div class="chat-users-card">
                            <div class="chat-users-header">
                                <h3>المستخدمون المتصلون</h3>
                            </div>
                            <div class="chat-users-body">
                                <ul class="chat-users-list">
                                    @if ($community->type == 'course')
                                        @foreach ($community->course->users as $user)
                                            <li class="chat-user {{ $user->isOnline ? 'online' : 'offline' }}">
                                                <div class="chat-user-avatar">
                                                    @if (!empty($user->image) && file_exists(public_path('uploads/' . $user->image)))
                                                        <img src="{{ asset('uploads/' . $user->image) }}"
                                                            alt="{{ $user->user_name }}">
                                                    @else
                                                        <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                            alt="{{ $user->user_name }}">
                                                    @endif
                                                </div>
                                                <div class="chat-user-info">
                                                    <div class="chat-user-name">{{ $user->user_name }}</div>
                                                    <div class="chat-user-status">
                                                        @if ($user->isOnline)
                                                            <span class="online-indicator"></span> متصل الآن
                                                        @else
                                                            <span class="offline-indicator"></span> غير متصل
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        @foreach ($community->cohort->trainees as $user)
                                            <li class="chat-user {{ $user->isOnline ? 'online' : 'offline' }}">
                                                <div class="chat-user-avatar">
                                                    @if (!empty($user->image) && file_exists(public_path('uploads/' . $user->image)))
                                                        <img src="{{ asset('uploads/' . $user->image) }}"
                                                            alt="{{ $user->user_name }}">
                                                    @else
                                                        <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                            alt="{{ $user->user_name }}">
                                                    @endif
                                                </div>
                                                <div class="chat-user-info">
                                                    <div class="chat-user-name">{{ $user->user_name }}</div>
                                                    <div class="chat-user-status">
                                                        @if ($user->isOnline)
                                                            <span class="online-indicator"></span> متصل الآن
                                                        @else
                                                            <span class="offline-indicator"></span> غير متصل
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('site_assets/js/community.js') }}"></script>
@endsection

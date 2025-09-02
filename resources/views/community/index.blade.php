@extends('site.layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <style>
        .community-section {
            background-color: #f8f8f8;
            padding: 50px 0;
        }

        .community-container {
            padding: 30px 0;
        }

        .community-title {
            margin-bottom: 30px;
            color: #333;
            font-weight: bold;
            position: relative;
            padding-bottom: 10px;
        }

        .community-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #FF7F00;
        }

        .community-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
            overflow: hidden;
            width: 100%;
            height: 100%;
            margin: 5%;
            display: flex;
            flex-direction: column;
        }

        .community-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .community-card-header {
            background-color: #FF7F00;
            color: #fff;
            padding: 15px 20px;
            font-weight: bold;
            font-size: 18px;
        }

        .community-card-body {
            padding: 20px;
            flex-grow: 1;
        }

        .community-card-description {
            color: #666;
            margin-bottom: 20px;
            max-height: 80px;
            overflow: hidden;
        }

        .community-card-footer {
            padding: 15px 20px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .community-btn {
            background-color: #FF7F00;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .community-btn:hover {
            background-color: #e67300;
            transform: scale(1.05);
            color: #fff;
            text-decoration: none;
        }

        .community-type-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .community-type-tab {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .community-type-tab.active {
            background-color: #FF7F00;
            color: #fff;
        }

        .community-type-tab:hover {
            background-color: #e0e0e0;
        }

        .community-type-tab.active:hover {
            background-color: #e67300;
        }

        .community-empty {
            text-align: center;
            padding: 50px 0;
            color: #999;
        }

        .community-empty i {
            font-size: 50px;
            margin-bottom: 20px;
            color: #ddd;
        }

        /* General Posts Section */
        .general-posts-section {
            margin-bottom: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .general-posts-header {
            background: linear-gradient(135deg, #FF7F00, #FF9E44);
            color: #fff;
            padding: 20px 25px;
            position: relative;
            overflow: hidden;
        }

        .general-posts-header h2 {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
        }

        .general-posts-header h2 i {
            margin-right: 10px;
            font-size: 1.2em;
        }

        .general-posts-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(30deg);
            z-index: 1;
        }

        .general-posts-body {
            padding: 0;
        }

        /* Facebook-like Post Styling */
        .post-item {
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            position: relative;
        }

        .post-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 15px;
            border: 3px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .post-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-info {
            flex-grow: 1;
        }

        .post-author {
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
            font-size: 16px;
        }

        .post-date {
            font-size: 12px;
            color: #65676B;
        }

        .post-options {
            position: relative;
        }

        .btn-post-options {
            background: none;
            border: none;
            color: #65676B;
            font-size: 20px;
            padding: 5px 10px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-post-options:hover {
            background-color: #F2F3F5;
            color: #050505;
        }

        .post-content {
            margin-bottom: 15px;
        }

        .post-text {
            color: #1C1E21;
            line-height: 1.5;
            margin-bottom: 15px;
            font-size: 15px;
            white-space: pre-line;
        }

        .post-media {
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Post Stats */
        .post-stats {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #E4E6EB;
            border-bottom: 1px solid #E4E6EB;
            margin-bottom: 10px;
            color: #65676B;
            font-size: 14px;
        }

        .post-reactions {
            display: flex;
            align-items: center;
        }

        .reaction-icon {
            margin-right: 5px;
        }

        /* Post Actions Bar */
        .post-actions-bar {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            margin-bottom: 15px;
        }

        .post-action-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 0;
            background: none;
            border: none;
            border-radius: 4px;
            color: #65676B;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .post-action-btn:hover {
            background-color: #F2F3F5;
        }

        .post-action-btn i {
            margin-right: 5px;
            font-size: 16px;
        }

        .post-action-btn.active {
            color: #FF7F00;
        }

        .post-action-btn.active i.far.fa-heart {
            font-weight: 900;
        }

        /* Comments Section */
        .post-comments-section {
            margin-top: 10px;
            padding-top: 10px;
        }

        .comment-form {
            display: flex;
            margin-bottom: 15px;
        }

        .comment-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .comment-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-input-wrapper {
            flex: 1;
            position: relative;
            background-color: #F0F2F5;
            border-radius: 20px;
            padding: 8px 15px;
            display: flex;
            align-items: center;
        }

        .comment-input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            color: #1C1E21;
        }

        .comment-actions {
            display: flex;
            align-items: center;
        }

        .comment-emoji-btn,
        .comment-attach-btn,
        .comment-submit-btn {
            background: none;
            border: none;
            color: #65676B;
            font-size: 16px;
            padding: 5px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .comment-emoji-btn:hover,
        .comment-attach-btn:hover,
        .comment-submit-btn:hover {
            color: #FF7F00;
        }

        .post-comments-container {
            margin-top: 10px;
        }

        .view-more-comments {
            text-align: center;
            margin-top: 10px;
        }

        .view-more-btn {
            background: none;
            border: none;
            color: #65676B;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .view-more-btn:hover {
            background-color: #F2F3F5;
            color: #050505;
        }

        /* Comment Item */
        .comment-item {
            display: flex;
            margin-bottom: 10px;
        }

        .comment-content {
            flex: 1;
            background-color: #F0F2F5;
            border-radius: 18px;
            padding: 8px 12px;
            position: relative;
        }

        .comment-author {
            font-weight: 600;
            font-size: 13px;
            color: #050505;
            margin-bottom: 2px;
        }

        .comment-text {
            font-size: 14px;
            color: #1C1E21;
            word-break: break-word;
        }

        .comment-time {
            font-size: 12px;
            color: #65676B;
            margin-top: 5px;
        }

        .comment-actions {
            display: flex;
            margin-top: 5px;
        }

        .comment-action-link {
            font-size: 12px;
            font-weight: 600;
            color: #65676B;
            margin-right: 10px;
            cursor: pointer;
        }

        .comment-action-link:hover {
            text-decoration: underline;
        }

        /* Loading animation */
        .loading-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            color: #65676B;
        }

        .loading-spinner {
            display: flex;
            margin-bottom: 10px;
        }

        .spinner-dot {
            width: 8px;
            height: 8px;
            margin: 0 3px;
            border-radius: 50%;
            background-color: #FF7F00;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .spinner-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .spinner-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }

        /* Post hover effects */
        .post-item:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        /* Like button animation */
        @keyframes likeAnimation {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .like-btn.active i {
            color: #FF7F00;
            animation: likeAnimation 0.3s ease-in-out;
        }

        /* Image hover effects */
        .image-container:hover .post-image {
            transform: scale(1.02);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .post-actions-bar {
                flex-wrap: wrap;
            }

            .post-action-btn {
                font-size: 12px;
            }

            .post-action-btn i {
                font-size: 14px;
            }

            .post-text {
                font-size: 14px;
            }
        }

        /* New Post Form */
        .new-post-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 15px;
        }

        .new-post-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #E4E6EB;
        }

        .new-post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .new-post-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .new-post-input-wrapper {
            flex: 1;
        }

        .new-post-input {
            width: 100%;
            background-color: #F0F2F5;
            border: none;
            border-radius: 20px;
            padding: 10px 15px;
            font-size: 15px;
            color: #1C1E21;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .new-post-input:hover {
            background-color: #E4E6EB;
        }

        .new-post-actions {
            display: flex;
            justify-content: space-around;
            padding-top: 10px;
        }

        .new-post-action {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 15px;
            border-radius: 4px;
            color: #65676B;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .new-post-action:hover {
            background-color: #F2F3F5;
        }

        .new-post-action i {
            margin-right: 5px;
            font-size: 18px;
        }

        .new-post-action.photo i {
            color: #45BD62;
        }

        .new-post-action.video i {
            color: #F3425F;
        }

        .new-post-action.feeling i {
            color: #F7B928;
        }

        /* Post Modal */
        .post-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .post-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .post-modal-content {
            width: 500px;
            max-width: 90%;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .post-modal.active .post-modal-content {
            transform: translateY(0);
        }

        .post-modal-header {
            padding: 15px;
            border-bottom: 1px solid #E4E6EB;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .post-modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #1C1E21;
        }

        .post-modal-close {
            background: none;
            border: none;
            color: #65676B;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .post-modal-close:hover {
            color: #1C1E21;
        }

        .post-modal-body {
            padding: 15px;
        }

        .post-modal-user {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .post-modal-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .post-modal-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-modal-user-info {
            flex: 1;
        }

        .post-modal-username {
            font-weight: 600;
            color: #1C1E21;
            font-size: 15px;
        }

        .post-modal-privacy {
            display: flex;
            align-items: center;
            font-size: 12px;
            color: #65676B;
        }

        .post-modal-privacy i {
            margin-right: 5px;
        }

        .post-modal-textarea {
            width: 100%;
            min-height: 150px;
            border: none;
            resize: none;
            font-size: 18px;
            color: #1C1E21;
            margin-bottom: 15px;
            outline: none;
            font-family: inherit;
        }

        .post-modal-footer {
            padding: 15px;
            border-top: 1px solid #E4E6EB;
        }

        .post-modal-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #E4E6EB;
            border-radius: 8px;
        }

        .post-modal-action {
            display: flex;
            align-items: center;
            color: #65676B;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        .post-modal-action i {
            margin-right: 5px;
            font-size: 20px;
        }

        .post-modal-action.photo i {
            color: #45BD62;
        }

        .post-modal-action.tag i {
            color: #1877F2;
        }

        .post-modal-action.feeling i {
            color: #F7B928;
        }

        .post-modal-action.location i {
            color: #F3425F;
        }

        .post-modal-submit {
            width: 100%;
            padding: 10px;
            background-color: #FF7F00;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .post-modal-submit:hover {
            background-color: #e67300;
        }

        .post-modal-submit:disabled {
            background-color: #E4E6EB;
            color: #BCC0C4;
            cursor: not-allowed;
        }

        .view-all-posts {
            text-align: center;
            padding: 15px 0;
            border-top: 1px solid #f0f0f0;
        }

        .view-all-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #FF7F00;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .view-all-btn:hover {
            color: #e67300;
            text-decoration: none;
        }

        .view-all-btn i {
            transition: transform 0.3s ease;
        }

        .view-all-btn:hover i {
            transform: translateX(5px);
        }

        /* Image Container */
        .image-container {
            position: relative;
            width: 100%;
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
            background-color: #f5f5f5;
            min-height: 200px;
            /* ضمان وجود مساحة للصورة */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-container:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .post-image-link {
            display: block;
            width: 100%;
            text-align: center;
        }


        .post-image {}

        /* Video Container */
        .video-container {
            position: relative;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post-video {
            width: 100%;
            max-height: 250px;
            background-color: #000;
        }

        /* Audio Container */
        .audio-container {
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .post-audio {
            width: 100%;
        }

        /* File Container */
        .file-container {
            padding: 15px;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .file-download-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            background-color: #FF7F00;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(255, 127, 0, 0.2);
        }

        .file-download-btn:hover {
            background-color: #e67300;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(255, 127, 0, 0.3);
            color: white;
            text-decoration: none;
        }

        .file-download-btn i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .file-extension {
            display: inline-block;
            padding: 3px 8px;
            margin-left: 10px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('content')
    <section class="community-container">
        <div class="container">
            <h1 class="community-title">{{ __('site.communities') }}</h1>


            <div class="community-type-tabs">
                <div class="community-type-tab active" data-target="courses">{{ __('site.course_communities') }}</div>
                @if (count($cohortCommunities) > 0)
                    <div class="community-type-tab" data-target="cohorts">{{ __('site.cohort_communities') }}</div>
                @endif
                <div class="community-type-tab " data-target="general">{{ __('site.general_community') }}</div>
            </div>
            <div class="community-section" id="general-section" style="display: none;">
                <div class="row">
                    <!-- General Posts Section -->
                    @if (isset($posts) && count($posts) > 0)
                        <div class="general-posts-header">
                            <h2><i class="fa fa-globe"></i> {{ __('site.general_posts') }}</h2>
                        </div>
                        <div class="general-posts-body">
                            @foreach ($posts as $post)
                                <div class="post-item">
                                    <div class="post-header">
                                        <div class="post-avatar">
                                            @if ($post->user->image)
                                                <img src="{{ asset(config('filesystems.disks.contabo.url') . '/' . $post->user->image) }}"
                                                    alt="{{ $post->user->user_name }}">
                                            @else
                                                <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                    alt="{{ $post->user->user_name }}">
                                            @endif
                                        </div>
                                        <div class="post-info">
                                            <div class="post-author">{{ $post->user->user_name }}</div>
                                            <div class="post-date">{{ $post->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-text">{{ $post->content }}</div>

                                        @if ($post->media_url)
                                            <div class="post-media">
                                                @if ($post->type == 'image')
                                                    <div class="image-container">
                                                        <a href="{{ config('filesystems.disks.contabo.url') . '/' . $post->media_url }}"
                                                            data-fancybox="gallery-{{ $post->id }}"
                                                            class="post-image-link">
                                                            <img src="{{ config('filesystems.disks.contabo.url') . '/' . $post->media_url }}"
                                                                onerror="this.onerror=null; this.src='{{ asset('site_assets/images/image-placeholder.png') }}'; console.error('Image failed to load');">
                                                        </a>
                                                    </div>
                                                @elseif($post->type == 'video')
                                                    <div class="video-container">
                                                        <video controls preload="metadata" class="post-video"
                                                            controlsList="nodownload" playsinline>
                                                            <source
                                                                src="{{ config('filesystems.disks.contabo.url') . '/' . $post->media_url }}"
                                                                type="video/mp4">
                                                            <source
                                                                src="{{ config('filesystems.disks.contabo.url') . '/' . $post->media_url }}"
                                                                type="video/webm">
                                                            <source
                                                                src="{{ config('filesystems.disks.contabo.url') . '/' . $post->media_url }}"
                                                                type="video/ogg">
                                                            {{ __('site.browser_not_support_video') }}
                                                        </video>
                                                    </div>
                                                @elseif($post->type == 'audio')
                                                    <div class="audio-container">
                                                        <audio controls class="post-audio">
                                                            <source
                                                                src="{{ asset(config('filesystems.disks.contabo.url') . '/' . $post->media_url) }}"
                                                                type="audio/mpeg">
                                                            {{ __('site.browser_not_support_audio') }}
                                                        </audio>
                                                    </div>
                                                @elseif($post->type == 'file')
                                                    <div class="file-container">
                                                        <a href="{{ asset(config('filesystems.disks.contabo.url') . '/' . $post->media_url) }}"
                                                            class="file-download-btn" target="_blank">
                                                            <i class="fa fa-file-download"></i>
                                                            <span>{{ __('site.download_file') }}</span>
                                                            <small
                                                                class="file-extension">{{ pathinfo($post->media_url, PATHINFO_EXTENSION) }}</small>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="post-stats">
                                        <div class="post-reactions">
                                            <span class="reaction-icon"><i class="fas fa-heart text-danger"></i></span>
                                            <span class="reaction-count">{{ $post->likes_count }}</span>
                                        </div>
                                        <div class="post-comments-count">
                                            <span>{{ $post->comments_count }} {{ __('site.comments') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="loading-indicator" style="display: none; text-align: center; padding: 20px;">
                            <div class="spinner-grow text-primary" role="status" style="width: 15px; height: 15px;">
                            </div>
                            <div class="spinner-grow text-secondary" role="status" style="width: 15px; height: 15px;">
                            </div>
                            <div class="spinner-grow text-success" role="status" style="width: 15px; height: 15px;">
                            </div>
                            <p>{{ __('site.loading_more_posts') }}...</p>
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="community-empty">
                                <i class="fa fa-newspaper"></i>
                                <h3>{{ __('site.no_general_posts') }}</h3>
                                <p>{{ __('site.no_general_posts_message') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="community-section" id="courses-section">
                <div class="row">
                    @if (count($courseCommunities) > 0)
                        @foreach ($courseCommunities as $community)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="community-card">
                                    <div class="community-card-header">
                                        {{ $community->name }}
                                    </div>
                                    <div class="community-card-body">
                                        <div class="community-card-description">
                                            {{ $community->description }}
                                        </div>
                                    </div>
                                    <div class="community-card-footer">
                                        <span>
                                            <i class="fa fa-users"></i>
                                            {{ $community->course->users->count() }} {{ __('site.members') }}
                                        </span>
                                        <a href="{{ route('community.show', $community->id) }}" class="community-btn">
                                            {{ __('site.join_community') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="community-empty">
                                <i class="fa fa-users"></i>
                                <h3>{{ __('site.no_course_communities') }}</h3>
                                <p>{{ __('site.no_course_communities_message') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="community-section" id="cohorts-section" style="display: none;">
                <div class="row">
                    @if (count($cohortCommunities) > 0)
                        @foreach ($cohortCommunities as $community)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="community-card">
                                    <div class="community-card-header">
                                        {{ $community->name }}
                                    </div>
                                    <div class="community-card-body">
                                        <div class="community-card-description">
                                            {{ $community->description }}
                                        </div>
                                    </div>
                                    <div class="community-card-footer">
                                        <span>
                                            <i class="fa fa-users"></i>
                                            {{ $community->cohort->trainees->count() }} {{ __('site.members') }}
                                        </span>
                                        <a href="{{ route('community.show', $community->id) }}" class="community-btn">
                                            {{ __('site.join_community') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="community-empty">
                                <i class="fa fa-users"></i>
                                <h3>{{ __('site.no_cohort_communities') }}</h3>
                                <p>{{ __('site.no_cohort_communities_message') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.post-image').each(function() {
                var img = $(this);
                var src = img.attr('src');
                console.log(src)
                // إعادة تحميل الصورة
                img.attr('src', '');
                setTimeout(function() {
                    img.attr('src', src);
                }, 100);

                // إظهار رسالة عند فشل تحميل الصورة
                img.on('error', function() {
                    console.error('فشل تحميل الصورة: ' + src);
                    $(this).closest('.image-container').html(
                        '<div class="alert alert-warning">فشل تحميل الصورة</div>');
                });
            });
            // Initialize Fancybox for any images
            Fancybox.bind("[data-fancybox]", {
                animationEffect: "zoom",
                transitionEffect: "fade",
                buttons: [
                    "zoom",
                    "slideShow",
                    "fullScreen",
                    "download",
                    "thumbs",
                    "close"
                ],
            });

            $('.community-type-tab').click(function() {
                $('.community-type-tab').removeClass('active');
                $(this).addClass('active');

                var target = $(this).data('target');
                $('.community-section').hide();
                $('#' + target + '-section').fadeIn();
            });

            // Add hover effects to posts
            $('.post-item').hover(
                function() {
                    $(this).css({
                        'transform': 'translateY(-2px)',
                        'box-shadow': '0 4px 8px rgba(0,0,0,0.05)'
                    });
                },
                function() {
                    $(this).css({
                        'transform': 'translateY(0)',
                        'box-shadow': 'none'
                    });
                }
            );

            // Add animation to view all button
            $('.view-all-btn').hover(
                function() {
                    $(this).find('i').css('transform', 'translateX(5px)');
                },
                function() {
                    $(this).find('i').css('transform', 'translateX(0)');
                }
            );

            // Equal height for community cards
            function equalizeCardHeights() {
                $('.community-section').each(function() {
                    var highestCard = 0;

                    $(this).find('.community-card').css('height', 'auto');

                    $(this).find('.community-card').each(function() {
                        if ($(this).height() > highestCard) {
                            highestCard = $(this).height();
                        }
                    });

                    $(this).find('.community-card').height(highestCard);
                });
            }

            // إضافة هذا الكود في قسم $(document).ready
            let isLoading = false;
            let nextPageUrl = "{{ $posts->nextPageUrl() }}";

            // تحميل المزيد من المنشورات عند النزول بالسكرول
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 300) {
                    loadMoreGeneralPosts();
                }
            });

            function loadMoreGeneralPosts() {
                if (isLoading || !nextPageUrl) return;
                isLoading = true;
                $('.loading-indicator').show();

                $.ajax({
                    url: nextPageUrl,
                    type: 'GET',
                    success: function(response) {
                        // إضافة المنشورات الجديدة
                        $('.general-posts-body .post-item:last').after(response.posts_html);

                        // تحديث رابط الصفحة التالية
                        nextPageUrl = response.next_page_url;

                        // إذا لم تعد هناك منشورات أخرى
                        if (!nextPageUrl) {
                            $('.loading-indicator').hide();
                            $('.general-posts-body').append(
                                '<div class="no-more-posts"><p>{{ __('site.no_more_posts') }}</p></div>'
                            );
                        }

                        // تهيئة Fancybox للصور الجديدة
                        Fancybox.bind("[data-fancybox]", {
                            animationEffect: "zoom",
                            transitionEffect: "fade",
                            buttons: [
                                "zoom",
                                "slideShow",
                                "fullScreen",
                                "download",
                                "thumbs",
                                "close"
                            ],
                        });

                        // إضافة تأثيرات التحويم للمنشورات الجديدة
                        $('.post-item').hover(
                            function() {
                                $(this).css({
                                    'transform': 'translateY(-2px)',
                                    'box-shadow': '0 4px 8px rgba(0,0,0,0.05)'
                                });
                            },
                            function() {
                                $(this).css({
                                    'transform': 'translateY(0)',
                                    'box-shadow': 'none'
                                });
                            }
                        );

                        isLoading = false;
                        $('.loading-indicator').hide();
                    },
                    error: function() {
                        $('.loading-indicator').hide();
                        isLoading = false;

                        // عرض رسالة خطأ
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: '{{ __('site.error_loading_more_posts') }}'
                        });
                    }
                });
            }

        });
    </script>
@endsection

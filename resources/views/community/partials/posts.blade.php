@php
    $nextPageUrl = $posts instanceof \Illuminate\Pagination\LengthAwarePaginator ? $posts->nextPageUrl() : null;
@endphp

@if ($nextPageUrl)
    <div class="nextPageUrl" data-next-page-url="{{ $nextPageUrl }}"></div>
@endif

@foreach ($posts as $post)
    <div class="post-item {{ $post->is_pinned ? 'pinned' : '' }}" id="post-{{ $post->id }}"
        data-type="{{ $post->type }}" data-media-url="{{ $post->media_url }}">
        <div class="post-header">
            <div class="post-avatar">
                @if ($post->user->image)
                    <img src="{{ asset('uploads/' . $post->user->image) }}" alt="{{ $post->user->user_name }}">
                @else
                    <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}" alt="{{ $post->user->user_name }}">
                @endif
            </div>
            <div class="post-info">
                <div class="post-author">{{ $post->user->user_name }}</div>
                <div class="post-date">{{ $post->created_at->diffForHumans() }}</div>
            </div>
            <!-- تعديل قسم خيارات المنشور -->
            @if (Auth::id() == $post->user_id || Auth::user()->role == 1)
                <div class="post-options">
                    <button type="button" class="post-options-btn">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="post-options-menu">
                        @if (Auth::id() == $post->user_id)
                            <div class="post-option edit-post" data-id="{{ $post->id }}">
                                <i class="fa fa-edit"></i> {{ __('site.edit') }}
                            </div>
                        @endif
                        <div class="post-option delete-post" data-id="{{ $post->id }}">
                            <i class="fa fa-trash"></i> {{ __('site.delete') }}
                        </div>
                        @if (Auth::user()->role == 1)
                            <div class="post-option pin-post" data-id="{{ $post->id }}" style="display: none;">
                                <i class="fa fa-thumbtack"></i>
                                {{ $post->is_pinned ? __('site.unpin') : __('site.pin') }}
                            </div>
                        @endif

                        <!-- إضافة خيار تفعيل/إلغاء تفعيل النشر على العام للفيديوهات -->
                        @if ($post->type == 'video' && (Auth::id() == $post->user_id || Auth::user()->role == 1))
                            <div class="post-option toggle-public-post" data-id="{{ $post->id }}"
                                data-is-public="{{ $post->publish_to_general ? '1' : '0' }}">
                                <i class="fa fa-globe"></i>
                                {{ $post->publish_to_general ? __('site.unpublish_from_general') : __('site.publish_to_general') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
        <div class="post-content">
            <div class="post-text">{{ $post->content }}</div>

            @if ($post->media_url)
                <div class="post-media">
                    @if ($post->type == 'image')
                        <div class="image-container">
                            <a href="{{ asset(config('filesystems.disks.contabo.url') . '/' . $post->media_url) }}"
                                data-fancybox="gallery-{{ $post->id }}" class="post-image-link">
                                <img src="{{ asset(config('filesystems.disks.contabo.url') . '/' . $post->media_url) }}"
                                    alt="Post image" class="post-image">
                            </a>
                        </div>
                    @elseif($post->type == 'video')
                        <div class="video-container">
                            <video controls class="post-video">
                                <source
                                    src="{{ asset(config('filesystems.disks.contabo.url') . '/' . $post->media_url) }}"
                                    type="video/mp4">
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
        <div class="post-footer">
            <div class="post-actions">
                <div class="post-action like-post {{ $post->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}"
                    data-id="{{ $post->id }}" data-type="post">
                    <i class="fa fa-heart"></i>
                    <span class="likes-count">{{ $post->likes_count }}</span> {{ __('site.likes') }}
                </div>
                <div class="post-action comment-toggle" data-id="{{ $post->id }}">
                    <i class="fa fa-comment"></i>
                    <span class="comments-count">{{ $post->comments_count }}</span>
                    {{ __('site.comments') }}
                </div>
            </div>

            <div class="post-comments" id="comments-{{ $post->id }}" style="display: none;">
                <div class="post-comments-header">{{ __('site.comments') }}</div>

                <div class="comments-list" id="comments-list-{{ $post->id }}">
                    @foreach ($post->comments->where('parent_id', null) as $comment)
                        <div class="comment-item" id="comment-{{ $comment->id }}">
                            <div class="comment-avatar">
                                @if ($comment->user->image)
                                    <img src="{{ asset('uploads/' . $comment->user->image) }}"
                                        alt="{{ $comment->user->user_name }}">
                                @else
                                    <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                        alt="{{ $comment->user->user_name }}">
                                @endif
                            </div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <div class="comment-author">{{ $comment->user->user_name }}</div>
                                    <div class="comment-date">{{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <div class="comment-text">{{ $comment->content }}</div>
                                <div class="comment-actions">
                                    <div class="comment-action like-comment {{ $comment->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}"
                                        data-id="{{ $comment->id }}" data-type="comment">
                                        <i class="fa fa-heart"></i>
                                        <span class="likes-count">{{ $comment->likes->count() }}</span>
                                    </div>
                                    <div class="comment-action reply-toggle" data-id="{{ $comment->id }}">
                                        <i class="fa fa-reply"></i> {{ __('site.reply') }}
                                    </div>
                                    @if (Auth::id() == $comment->user_id || Auth::user()->role == 1)
                                        <div class="comment-action edit-comment" data-id="{{ $comment->id }}">
                                            <i class="fa fa-edit"></i> {{ __('site.edit') }}
                                        </div>
                                        <div class="comment-action delete-comment" data-id="{{ $comment->id }}">
                                            <i class="fa fa-trash"></i> {{ __('site.delete') }}
                                        </div>
                                    @endif
                                </div>

                                @if ($comment->replies->count() > 0)
                                    <div class="comment-replies" id="replies-{{ $comment->id }}">
                                        @foreach ($comment->replies as $reply)
                                            <div class="comment-item" id="comment-{{ $reply->id }}">
                                                <div class="comment-avatar">
                                                    @if ($reply->user->image)
                                                        <img src="{{ asset('uploads/' . $reply->user->image) }}"
                                                            alt="{{ $reply->user->user_name }}">
                                                    @else
                                                        <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                            alt="{{ $reply->user->user_name }}">
                                                    @endif
                                                </div>
                                                <div class="comment-content">
                                                    <div class="comment-header">
                                                        <div class="comment-author">
                                                            {{ $reply->user->user_name }}</div>
                                                        <div class="comment-date">
                                                            {{ $reply->created_at->diffForHumans() }}</div>
                                                    </div>
                                                    <div class="comment-text">{{ $reply->content }}</div>
                                                    <div class="comment-actions">
                                                        <div class="comment-action like-comment {{ $reply->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}"
                                                            data-id="{{ $reply->id }}" data-type="comment">
                                                            <i class="fa fa-heart"></i>
                                                            <span class="likes-count">{{ $reply->likes_count }}</span>
                                                        </div>
                                                        @if (Auth::id() == $reply->user_id || Auth::user()->role == 1)
                                                            <div class="comment-action edit-comment"
                                                                data-id="{{ $reply->id }}">
                                                                <i class="fa fa-edit"></i>
                                                                {{ __('site.edit') }}
                                                            </div>
                                                            <div class="comment-action delete-comment"
                                                                data-id="{{ $reply->id }}">
                                                                <i class="fa fa-trash"></i>
                                                                {{ __('site.delete') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="comment-create reply-form" id="reply-form-{{ $comment->id }}"
                                    style="display: none;">
                                    <div class="comment-create-avatar">
                                        @if (Auth::user()->image)
                                            <img src="{{ asset('uploads/' . Auth::user()->image) }}"
                                                alt="{{ Auth::user()->user_name }}">
                                        @else
                                            <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                alt="{{ Auth::user()->user_name }}">
                                        @endif
                                    </div>
                                    <div class="comment-create-input">
                                        <form class="reply-comment-form" data-parent="{{ $comment->id }}"
                                            data-post="{{ $post->id }}">
                                            <textarea class="comment-create-textarea" placeholder="{{ __('site.write_a_reply') }}"></textarea>
                                            <button type="submit" class="comment-create-submit">
                                                <i class="fa fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="comment-create">
                    <div class="comment-create-avatar">
                        @if (Auth::user()->image)
                            <img src="{{ asset('uploads/' . Auth::user()->image) }}"
                                alt="{{ Auth::user()->user_name }}">
                        @else
                            <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                alt="{{ Auth::user()->user_name }}">
                        @endif
                    </div>
                    <div class="comment-create-input">
                        <form class="add-comment-form" data-post="{{ $post->id }}">
                            <textarea class="comment-create-textarea" placeholder="{{ __('site.write_a_comment') }}"></textarea>
                            <button type="submit" class="comment-create-submit">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

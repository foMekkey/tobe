@foreach ($posts as $post)
    <div class="post-item">
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
                <div class="post-action {{ $post->likes->where('user_id', Auth::id())->count() ? 'liked' : '' }}">
                    <i class="fa fa-heart"></i>
                    <span>{{ $post->likes_count }}</span>
                </div>
                <div class="post-action">
                    <i class="fa fa-comment"></i>
                    <span>{{ $post->comments_count }}</span>
                </div>
            </div>
        </div>
    </div>
@endforeach

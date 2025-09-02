<div class="comment-item" id="comment-{{ $comment->id }}">
    <div class="comment-avatar">
        @if ($comment->user->image)
            <img src="{{ asset('uploads/' . $comment->user->image) }}" alt="{{ $comment->user->user_name }}">
        @else
            <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}" alt="{{ $comment->user->user_name }}">
        @endif
    </div>
    <div class="comment-content">
        <div class="comment-header">
            <div class="comment-author">{{ $comment->user->user_name }}</div>
            <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
        </div>
        <div class="comment-text">{{ $comment->content }}</div>
        <div class="comment-actions">
            <div class="comment-action like-comment {{ $comment->isLikedByUser(auth()->user()) ? 'liked' : '' }}"
                data-id="{{ $comment->id }}">
                <i class="fa fa-heart"></i> <span class="likes-count">{{ $comment->likes->count() }}</span>
            </div>
            <div class="comment-action reply-toggle" data-id="{{ $comment->id }}" style="display: none;">
                <i class="fa fa-reply"></i> {{ __('site.reply') }}
            </div>
            @if (auth()->id() == $comment->user_id)
                <div class="comment-action edit-comment" data-id="{{ $comment->id }}">
                    <i class="fa fa-edit"></i> {{ __('site.edit') }}
                </div>
                <div class="comment-action delete-comment" data-id="{{ $comment->id }}">
                    <i class="fa fa-trash"></i> {{ __('site.delete') }}
                </div>
            @endif
        </div>

        <!-- نموذج الرد -->
        <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none;">
            <form class="reply-comment-form" data-post="{{ $comment->post_id }}" data-parent="{{ $comment->id }}">
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
                        <textarea class="comment-create-textarea" placeholder="{{ __('site.write_a_reply') }}"></textarea>
                        <button type="submit" class="comment-create-submit">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- قائمة الردود -->
        <div class="comment-replies">
            @foreach ($comment->replies as $reply)
                @include('community.partials.reply', ['reply' => $reply])
            @endforeach
        </div>
    </div>
</div>

<div class="comment-item reply-item" id="comment-{{ $reply->id }}">
    <div class="comment-avatar">
        @if ($reply->user->image)
            <img src="{{ asset('uploads/' . $reply->user->image) }}" alt="{{ $reply->user->user_name }}">
        @else
            <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}" alt="{{ $reply->user->user_name }}">
        @endif
    </div>
    <div class="comment-content">
        <div class="comment-header">
            <div class="comment-author">{{ $reply->user->user_name }}</div>
            <div class="comment-date">{{ $reply->created_at->diffForHumans() }}</div>
        </div>
        <div class="comment-text">{{ $reply->content }}</div>
        <div class="comment-actions">
            <div class="comment-action like-comment {{ $reply->isLikedByUser(auth()->user()) ? 'liked' : '' }}"
                data-id="{{ $reply->id }}">
                <i class="fa fa-heart"></i> <span class="likes-count">{{ $reply->likes->count() }}</span>
            </div>
            @if (auth()->id() == $reply->user_id)
                <div class="comment-action edit-comment" data-id="{{ $reply->id }}">
                    <i class="fa fa-edit"></i> {{ __('site.edit') }}
                </div>
                <div class="comment-action delete-comment" data-id="{{ $reply->id }}">
                    <i class="fa fa-trash"></i> {{ __('site.delete') }}
                </div>
            @endif
        </div>
    </div>
</div>

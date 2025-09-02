@extends('site.layouts.app')

@section('styles')
    <link href="{{ asset('site_assets/css/custom.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <section class="inner_banner">
        <div class="container-fluid">
            <div class="sub_title">
                <h1>{{ $community->name }}</h1>
                <h3>{{ $community->type == 'course' ? 'مجتمع دورة تدريبية' : 'مجتمع فوج تدريبي' }}</h3>
            </div>
            <ul class="list-inline">
                <li><a href="{{ url('site') }}">{{ __('site.home') }}</a></li>
                <li><a href="{{ route('community.index') }}">{{ __('site.communities') }}</a></li>
                <li><a href="#">{{ $community->name }}</a></li>
            </ul>
        </div>
    </section>

    <section class="community-page">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- نموذج إنشاء منشور جديد -->
                    <div class="create-post-card">
                        <div class="create-post-header">
                            <h3>إنشاء منشور جديد</h3>
                        </div>
                        <form id="create-post-form" enctype="multipart/form-data">
                            <div class="create-post-body">
                                <textarea class="create-post-textarea" name="content" placeholder="ماذا تريد أن تشارك اليوم؟"></textarea>
                                <div class="create-post-media-preview"></div>
                            </div>
                            <div class="create-post-footer">
                                <div class="create-post-actions">
                                    <label for="post-media" class="create-post-action">
                                        <i class="fa fa-image"></i>
                                        <span>إضافة صورة</span>
                                    </label>
                                    <input type="file" id="post-media" name="media" style="display: none"
                                        accept="image/*">
                                </div>
                                <input type="hidden" name="community_id" value="{{ $community->id }}">
                                <button type="submit" class="create-post-submit" disabled>نشر</button>
                            </div>
                        </form>
                    </div>

                    <!-- المنشورات المثبتة -->
                    @if (count($pinnedPosts) > 0)
                        <div class="posts-section">
                            <div class="posts-section-header">
                                <h3>المنشورات المثبتة</h3>
                            </div>
                            @foreach ($pinnedPosts as $post)
                                <div class="post-card pinned" id="post-{{ $post->id }}"
                                    data-post-id="{{ $post->id }}">
                                    <div class="post-header">
                                        <div class="post-user">
                                            <div class="post-avatar">
                                                @if (!empty($post->user->image) && file_exists(public_path('uploads/' . $post->user->image)))
                                                    <img src="{{ asset('uploads/' . $post->user->image) }}"
                                                        alt="{{ $post->user->user_name }}">
                                                @else
                                                    <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                        alt="{{ $post->user->user_name }}">
                                                @endif
                                            </div>
                                            <div class="post-user-info">
                                                <div class="post-username">{{ $post->user->user_name }}</div>
                                                <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <div class="post-options">
                                            <div class="post-options-toggle">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </div>
                                            <div class="post-options-menu">
                                                @can('update', $post)
                                                    <div class="post-option"
                                                        onclick="window.location.href='{{ route('community.post.edit', $post->id) }}'">
                                                        <i class="fa fa-edit"></i>
                                                        <span>تعديل</span>
                                                    </div>
                                                @endcan

                                                @can('delete', $post)
                                                    <div class="post-option" onclick="deletePost({{ $post->id }})">
                                                        <i class="fa fa-trash"></i>
                                                        <span>حذف</span>
                                                    </div>
                                                @endcan

                                                @can('pin', $post)
                                                    <div class="post-option" onclick="pinPost({{ $post->id }})">
                                                        <i class="fa fa-thumbtack"></i>
                                                        <span>إلغاء التثبيت</span>
                                                    </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post-body">
                                        <div class="post-text">{{ $post->content }}</div>
                                        @if ($post->media)
                                            <div class="post-media">
                                                <img src="{{ asset('uploads/community/' . $post->media) }}"
                                                    alt="صورة المنشور">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="post-footer">
                                        <div class="post-stats">
                                            <div class="post-stat like {{ $post->likes->contains('user_id', Auth::id()) ? 'liked' : '' }}"
                                                data-post-id="{{ $post->id }}"
                                                onclick="likePost({{ $post->id }})">
                                                <i class="fa fa-heart"></i>
                                                <span class="likes-count">{{ $post->likes->count() }}</span>
                                            </div>
                                            <div class="post-stat">
                                                <i class="fa fa-comment"></i>
                                                <span>{{ $post->comments->count() }}</span>
                                            </div>
                                        </div>
                                        <div class="post-actions">
                                            <div class="post-action comment"
                                                onclick="document.querySelector('#comment-form-{{ $post->id }} textarea').focus()">
                                                <i class="fa fa-comment"></i>
                                                <span>تعليق</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- قسم التعليقات -->
                                    <div class="comments-section">
                                        <form class="comment-form" id="comment-form-{{ $post->id }}"
                                            data-post-id="{{ $post->id }}">
                                            <textarea class="comment-create-textarea" placeholder="أضف تعليقاً..."></textarea>
                                            <button type="submit" class="comment-submit">تعليق</button>
                                        </form>

                                        @if (count($post->comments->where('parent_id', null)) > 0)
                                            <div class="comments-list">
                                                @foreach ($post->comments->where('parent_id', null) as $comment)
                                                    <div class="comment" id="comment-{{ $comment->id }}"
                                                        data-comment-id="{{ $comment->id }}">
                                                        <div class="comment-header">
                                                            <div class="comment-user">
                                                                <div class="comment-avatar">
                                                                    @if (!empty($comment->user->image) && file_exists(public_path('uploads/' . $comment->user->image)))
                                                                        <img src="{{ asset('uploads/' . $comment->user->image) }}"
                                                                            alt="{{ $comment->user->user_name }}">
                                                                    @else
                                                                        <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                                            alt="{{ $comment->user->user_name }}">
                                                                    @endif
                                                                </div>
                                                                <div class="comment-username">
                                                                    {{ $comment->user->user_name }}</div>
                                                            </div>
                                                            <div class="comment-time">
                                                                {{ $comment->created_at->diffForHumans() }}</div>
                                                            <div class="comment-options">
                                                                <div class="comment-options-toggle">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </div>
                                                                <div class="comment-options-menu">
                                                                    @can('update', $comment)
                                                                        <div class="comment-option"
                                                                            onclick="window.location.href='{{ route('community.comment.edit', $comment->id) }}'">
                                                                            <i class="fa fa-edit"></i>
                                                                            <span>تعديل</span>
                                                                        </div>
                                                                    @endcan

                                                                    @can('delete', $comment)
                                                                        <div class="comment-option"
                                                                            onclick="deleteComment({{ $comment->id }})">
                                                                            <i class="fa fa-trash"></i>
                                                                            <span>حذف</span>
                                                                        </div>
                                                                    @endcan
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="comment-body">{{ $comment->content }}</div>
                                                        <div class="comment-footer">
                                                            <div class="comment-stats">
                                                                <div class="comment-stat like {{ $comment->likes->contains('user_id', Auth::id()) ? 'liked' : '' }}"
                                                                    data-comment-id="{{ $comment->id }}"
                                                                    onclick="likeComment({{ $comment->id }})">
                                                                    <i class="fa fa-heart"></i>
                                                                    <span
                                                                        class="likes-count">{{ $comment->likes->count() }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="comment-actions">
                                                                <div class="comment-action reply"
                                                                    data-comment-id="{{ $comment->id }}">رد</div>
                                                            </div>
                                                        </div>

                                                        <!-- نموذج الرد على التعليق -->
                                                        <form class="reply-form" data-post-id="{{ $post->id }}"
                                                            data-comment-id="{{ $comment->id }}">
                                                            <textarea class="comment-create-textarea" placeholder="أضف رداً..."></textarea>
                                                            <button type="submit" class="comment-submit">رد</button>
                                                        </form>

                                                        <!-- الردود على التعليق -->
                                                        @if (count($comment->replies) > 0)
                                                            <div class="comment-replies">
                                                                @foreach ($comment->replies as $reply)
                                                                    <div class="comment" id="comment-{{ $reply->id }}"
                                                                        data-comment-id="{{ $reply->id }}">
                                                                        <div class="comment-header">
                                                                            <div class="comment-user">
                                                                                <div class="comment-avatar">
                                                                                    @if (!empty($reply->user->image) && file_exists(public_path('uploads/' . $reply->user->image)))
                                                                                        <img src="{{ asset('uploads/' . $reply->user->image) }}"
                                                                                            alt="{{ $reply->user->user_name }}">
                                                                                    @else
                                                                                        <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                                                            alt="{{ $reply->user->user_name }}">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="comment-username">
                                                                                    {{ $reply->user->user_name }}</div>
                                                                            </div>
                                                                            <div class="comment-time">
                                                                                {{ $reply->created_at->diffForHumans() }}
                                                                            </div>
                                                                            <div class="comment-options">
                                                                                <div class="comment-options-toggle">
                                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                                </div>
                                                                                <div class="comment-options-menu">
                                                                                    @can('update', $reply)
                                                                                        <div class="comment-option"
                                                                                            onclick="window.location.href='{{ route('community.comment.edit', $reply->id) }}'">
                                                                                            <i class="fa fa-edit"></i>
                                                                                            <span>تعديل</span>
                                                                                        </div>
                                                                                    @endcan

                                                                                    @can('delete', $reply)
                                                                                        <div class="comment-option"
                                                                                            onclick="deleteComment({{ $reply->id }})">
                                                                                            <i class="fa fa-trash"></i>
                                                                                            <span>حذف</span>
                                                                                        </div>
                                                                                    @endcan
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="comment-body">{{ $reply->content }}
                                                                        </div>
                                                                        <div class="comment-footer">
                                                                            <div class="comment-stats">
                                                                                <div class="comment-stat like {{ $reply->likes->contains('user_id', Auth::id()) ? 'liked' : '' }}"
                                                                                    data-comment-id="{{ $reply->id }}"
                                                                                    onclick="likeComment({{ $reply->id }})">
                                                                                    <i class="fa fa-heart"></i>
                                                                                    <span
                                                                                        class="likes-count">{{ $reply->likes->count() }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- المنشورات العادية -->
                    <div class="posts-section">
                        <div class="posts-section-header">
                            <h3>المنشورات</h3>
                        </div>

                        @if (count($posts) > 0)
                            @foreach ($posts as $post)
                                <div class="post-card" id="post-{{ $post->id }}"
                                    data-post-id="{{ $post->id }}">
                                    <div class="post-header">
                                        <div class="post-user">
                                            <div class="post-avatar">
                                                @if (!empty($post->user->image) && file_exists(public_path('uploads/' . $post->user->image)))
                                                    <img src="{{ asset('uploads/' . $post->user->image) }}"
                                                        alt="{{ $post->user->user_name }}">
                                                @else
                                                    <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                        alt="{{ $post->user->user_name }}">
                                                @endif
                                            </div>
                                            <div class="post-user-info">
                                                <div class="post-username">{{ $post->user->user_name }}</div>
                                                <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <div class="post-options">
                                            <div class="post-options-toggle">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </div>
                                            <div class="post-options-menu">
                                                @can('update', $post)
                                                    <div class="post-option"
                                                        onclick="window.location.href='{{ route('community.post.edit', $post->id) }}'">
                                                        <i class="fa fa-edit"></i>
                                                        <span>تعديل</span>
                                                    </div>
                                                @endcan

                                                @can('delete', $post)
                                                    <div class="post-option" onclick="deletePost({{ $post->id }})">
                                                        <i class="fa fa-trash"></i>
                                                        <span>حذف</span>
                                                    </div>
                                                @endcan

                                                <div class="post-option" onclick="pinPost({{ $post->id }})">
                                                    <i class="fa fa-thumbtack"></i>
                                                    <span>تثبيت</span>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                <div class="post-body">
                                    <div class="post-text">{{ $post->content }}</div>
                                    @if ($post->media)
                                        <div class="post-media">
                                            <img src="{{ asset('uploads/community/' . $post->media) }}"
                                                alt="صورة المنشور">
                                        </div>
                                    @endif
                                </div>
                                <div class="recent-activity-text">
                                    <strong>{{ $activity->user->user_name }}</strong>
                                    @if ($activity->type == 'post')
                                        قام بإنشاء منشور جديد
                                    @elseif($activity->type == 'comment')
                                        علق على منشور
                                    @elseif($activity->type == 'like')
                                        أعجب بـ {{ $activity->likeable_type == 'App\Models\Post' ? 'منشور' : 'تعليق' }}
                                    @endif
                                </div>
                                <div class="recent-activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                            </li>
                        @endforeach
                        </ul>
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

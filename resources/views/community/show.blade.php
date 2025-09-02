@extends('site.layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="{{ asset('css/community/show.css') }}?v={{ time() }}">
@endsection

@section('content')
    <!-- استبدل قسم community-header بالكامل بهذا الكود -->
    <section class="community-header"
        @if ($community->cover_image) style="background-image: url('{{ asset(config('filesystems.disks.contabo.url') . '/' . $community->cover_image) }}');" @endif>
        <div class="community-header-overlay"></div>
        <div class="container position-relative">
            <h1 class="community-title">{{ $community->name }}</h1>
            <p class="community-description">{{ $community->description }}</p>
            <div class="community-stats">
                <div class="community-stat">
                    <i class="fa fa-users"></i>
                    @if ($community->type == 'course')
                        <span>{{ $community->course->users->count() }} {{ __('site.members') }}</span>
                    @else
                        <span>{{ $community->cohort->trainees->count() }} {{ __('site.members') }}</span>
                    @endif
                </div>
                <div class="community-stat">
                    <i class="fa fa-comment"></i>
                    <span>{{ $community->posts->count() }} {{ __('site.posts') }}</span>
                </div>
            </div>

            <div class="community-actions">

                <a href="{{ route(config('chatify.routes.prefix'), ['community' => Crypt::encrypt($community->id)]) }}"
                    class="btn btn-primary">
                    {{ __('site.chat') }}
                </a>
            </div>
        </div>
    </section>


    <section class="community-content">
        <div class="container">
            <div class="post-create">
                <form id="post-form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="community_id" value="{{ $community->id }}">
                    <input type="hidden" name="type" value="text" id="post-type">

                    <div class="post-create-header">
                        <div class="post-create-avatar">
                            @if (Auth::user()->image)
                                <img src="{{ asset('uploads/' . Auth::user()->image) }}"
                                    alt="{{ Auth::user()->user_name }}">
                            @else
                                <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                    alt="{{ Auth::user()->user_name }}">
                            @endif
                        </div>
                        <div class="post-create-input">
                            <textarea class="post-create-textarea" name="content" placeholder="{{ __('site.whats_on_your_mind') }}"></textarea>
                        </div>
                    </div>

                    <div class="media-preview">
                        <div class="position-relative">
                            <div id="media-preview-content"></div>
                            <div class="media-preview-filename" id="upload-filename"></div>
                            <button type="button" class="media-preview-close" id="remove-media">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="post-create-actions">
                        <div class="d-flex justify-content-between w-100 align-items-center">
                            <div class="upload-buttons-container">
                                <label class="upload-button image" for="image-upload">
                                    <i class="fa fa-image"></i>
                                    <span>{{ __('site.photo') }}</span>
                                    <input type="file" id="image-upload" name="media" accept="image/*"
                                        style="display: none;">
                                </label>
                                <label class="upload-button video" for="video-upload">
                                    <i class="fa fa-video"></i>
                                    <span>{{ __('site.video') }}</span>
                                    <input type="file" id="video-upload" name="media" accept="video/*"
                                        style="display: none;">
                                </label>
                                <label class="upload-button audio" for="audio-upload">
                                    <i class="fa fa-music"></i>
                                    <span>{{ __('site.audio') }}</span>
                                    <input type="file" id="audio-upload" name="media" accept="audio/*"
                                        style="display: none;">
                                </label>
                                <label class="upload-button file" for="file-upload">
                                    <i class="fa fa-file"></i>
                                    <span>{{ __('site.file') }}</span>
                                    <input type="file" id="file-upload" name="media" style="display: none;">
                                </label>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="publish-to-general mr-3">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="publish_to_general"
                                            id="publish-to-general">
                                        <span class="custom-control-label">{{ __('site.publish_to_general') }}</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn-save post-create-submit">{{ __('site.post') }}</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="post-list" data-next-page-url="{{ $posts->nextPageUrl() }}">
                @include('community.partials.posts', ['posts' => $posts, 'community' => $community])
                <div class="loading-indicator" style="display: none; text-align: center; padding: 20px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">{{ __('site.loading') }}...</span>
                    </div>
                    <p>{{ __('site.loading_more_posts') }}...</p>
                </div>
            </div>
        </div>
    </section>
    <button id="back-to-top" class="back-to-top-btn" title="{{ __('site.back_to_top') }}">
        <i class="fa fa-chevron-up"></i>
    </button>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        var csrfToken = "{{ csrf_token() }}";
        var communityShowUrl = "{{ route('community.show', $community->id) }}";
        var postStoreUrl = "{{ route('community.post.store', $community->id) }}";
        var postUpdateUrl = "{{ route('community.post.update', ':id') }}";
        var postDestroyUrl = "{{ route('community.post.destroy', ':post') }}";
        var postPinUrl = "{{ url('community/post') }}/:id/pin";
        var postLikeUrl = "{{ route('community.post.like', ':post') }}";
        var commentStoreUrl = "{{ route('community.comment.store') }}";
        var commentUpdateUrl = "{{ route('community.comment.update', ':comment') }}";
        var commentDestroyUrl = "{{ route('community.comment.destroy', ':comment') }}";
        var commentLikeUrl = "{{ route('community.comment.like', ':comment') }}";
        var mediaBaseUrl = "{{ asset(config('filesystems.disks.contabo.url')) }}";
        var noMorePostsText = "{{ __('site.no_more_posts') }}";
        var errorLoadingMorePostsText = "{{ __('site.error_loading_more_posts') }}";
        var pleaseEnterContentText = "{{ __('site.please_enter_content_or_attach_file') }}";
        var uploadingText = "{{ __('site.uploading') }}..";
        var postCreatedSuccessText = "{{ __('site.post_created_successfully') }}";
        var errorCreatingPostText = "{{ __('site.error_creating_post') }}";
        var commentAddedSuccessText = "{{ __('site.comment_added_successfully') }}";
        var errorAddingCommentText = "{{ __('site.error_adding_comment') }}";
        var replyAddedSuccessText = "{{ __('site.reply_added_successfully') }}";
        var errorAddingReplyText = "{{ __('site.error_adding_reply') }}";
        var photoText = "{{ __('site.photo') }}";
        var videoText = "{{ __('site.video') }}";
        var audioText = "{{ __('site.audio') }}";
        var fileText = "{{ __('site.file') }}";
        var cancelText = "{{ __('site.cancel') }}";
        var saveText = "{{ __('site.save') }}";
        var savingText = "{{ __('site.saving') }}..";
        var errorUpdatingPostText = "{{ __('site.error_updating_post') }}";
        var confirmDeletePostText = "{{ __('site.confirm_delete_post') }}";
        var errorDeletingPostText = "{{ __('site.error_deleting_post') }}";
        var errorPinningPostText = "{{ __('site.error_pinning_post') }}";
        var confirmDeleteCommentText = "{{ __('site.confirm_delete_comment') }}";
        var errorUpdatingCommentText = "{{ __('site.error_updating_comment') }}";
        var errorDeletingCommentText = "{{ __('site.error_deleting_comment') }}";
        var errorLikingPostText = "{{ __('site.error_liking_post') }}";
        var errorLikingCommentText = "{{ __('site.error_liking_comment') }}";
        var releaseToRefreshText = "{{ __('site.release_to_refresh') }}";
        var pullToRefreshText = "{{ __('site.pull_to_refresh') }}";
        var refreshingText = "{{ __('site.refreshing') }}...";
        var postsRefreshedText = "{{ __('site.posts_refreshed') }}";
        var errorRefreshingPostsText = "{{ __('site.error_refreshing_posts') }}";

        // إضافة متغيرات Pusher
        var pusherAppKey = "{{ env('PUSHER_APP_KEY') }}";
        var pusherAppCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
        var communityId = {{ $community->id }};
        var currentUserId = {{ Auth::id() }};


        var postTogglePublicUrl = "{{ url('community/post') }}/:id/toggle-public";

        // أضف هذا الكود في قسم document.ready
        $(document).on('click', '.toggle-public-post', function() {
            var postId = $(this).data('id');
            var isPublic = $(this).data('is-public') === '1';
            var button = $(this);

            // عرض مؤشر التحميل
            Swal.fire({
                title: isPublic ? "{{ __('site.unpublishing') }}..." : "{{ __('site.publishing') }}...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // إرسال طلب AJAX لتحديث حالة النشر
            $.ajax({
                url: postTogglePublicUrl.replace(':id', postId),
                type: 'POST',
                data: {
                    _token: csrfToken
                },
                success: function(response) {
                    // تحديث واجهة المستخدم
                    if (response.success) {
                        // تحديث نص الزر وأيقونته
                        if (response.is_public) {
                            button.html(
                                '<i class="fa fa-globe"></i> {{ __('site.unpublish_from_general') }}'
                                );
                            button.data('is-public', '1');
                        } else {
                            button.html(
                                '<i class="fa fa-globe"></i> {{ __('site.publish_to_general') }}');
                            button.data('is-public', '0');
                        }

                        // عرض رسالة نجاح
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        // عرض رسالة خطأ
                        Swal.fire({
                            icon: 'error',
                            title: "{{ __('site.error') }}",
                            text: response.message
                        });
                    }
                },
                error: function(e) {
                    console.error('Error:', e);
                    // عرض رسالة خطأ
                    Swal.fire({
                        icon: 'error',
                        title: "{{ __('site.error') }}",
                        text: "{{ __('site.error_updating_post_status') }}"
                    });
                }
            });
        });
    </script>
    <script src="{{ asset('js/community/show.js') }}?v={{ rand(1, 1000) }}"></script>
@endsection

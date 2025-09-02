/**
 * Community Show Page JavaScript
 * Handles post loading, interactions, and media functionality
 */

// Global state variables
let isLoading = false;
let nextPageUrl = "";
let lastScrollPosition = 0;
const scrollThreshold = 200;

/**
 * Initialize event handlers for dynamic content
 * This ensures events work properly after AJAX content updates
 */
function initializeEventHandlers() {
    // Post options dropdown toggle
    $('.post-options-btn').off('click').on('click', function (e) {
        e.stopPropagation();
        $(this).next('.post-options-menu').toggleClass('show');
    });

    // Comments section toggle
    $(document).off('click', '.comment-toggle').on('click', '.comment-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const postId = $(this).data('id');
        $('#comments-' + postId).slideToggle(300);
        return false;
    });

    // Reply form toggle
    $(document).off('click', '.reply-toggle').on('click', '.reply-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const commentId = $(this).data('id');
        const replyForm = $('#reply-form-' + commentId);

        if (replyForm.is(':visible')) {
            replyForm.slideUp(300);
        } else {
            $('.reply-comment-form').not(replyForm).slideUp(300);
            replyForm.slideDown(300);
        }
        return false;
    });
}

/**
 * Load more posts via AJAX
 * Handles pagination and appends new content to the post list
 */
function loadMorePosts() {
    // Prevent multiple simultaneous requests
    // if (isLoading || !nextPageUrl) return;

    isLoading = true;
    $('.loading-indicator').show();

    $.ajax({
        url: nextPageUrl,
        type: 'GET',
        dataType: 'html',
        cache: false,
        success: function (response) {
            // Append new posts to the list
            $('.post-list').append(response);

            nextPageUrl = $(response).filter('.nextPageUrl').data('next-page-url');
            $('.post-list').data('next-page-url', nextPageUrl);

            // If no more posts, show the message
            if (!nextPageUrl) {
                $('.loading-indicator').hide();
                $('.post-list').append('<div class="no-more-posts"><p>' + noMorePostsText + '</p></div>');
            }

            // Initialize components for new content
            initializeFancybox();
            initializeEventHandlers();

            isLoading = false;
            $('.loading-indicator').hide();
        },
        error: function (xhr) {
            $('.loading-indicator').hide();

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorLoadingMorePostsText,
                confirmButtonColor: '#1877f2'
            });

            isLoading = false;
        }
    });
}

/**
 * Initialize Fancybox for image lightbox
 */
function initializeFancybox() {
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
        ]
    });
}

/**
 * Show alert messages using SweetAlert
 * @param {string} type - Alert type (success, error, warning, info)
 * @param {string} message - Alert message text
 */
function showAlert(type, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    Toast.fire({
        icon: type,
        title: message
    });
}

/**
 * Refresh posts to get the latest content
 * @param {Function} callback - Function to call after refresh completes
 */
function refreshPosts(callback) {
    $.ajax({
        url: communityShowUrl,
        type: 'GET',
        dataType: 'html',
        cache: false,
        success: function (response) {
            const $response = $(response);
            const $newPosts = $response.find('.post-item');

            $('.post-list .post-item').fadeOut(300, function () {
                $('.post-list .post-item').remove();
                $('.no-more-posts').remove();

                $newPosts.each(function (index) {
                    const $post = $(this);
                    $post.css('opacity', 0);

                    $('.loading-indicator').before($post);

                    setTimeout(function () {
                        $post.css('transform', 'translateY(20px)');
                        $post.animate({
                            opacity: 1,
                            transform: 'translateY(0)'
                        }, 500);
                    }, index * 100);
                });

                // Update next page URL
                const $postList = $response.find('.post-list');
                nextPageUrl = $postList.data('next-page-url');
                $('.post-list').data('next-page-url', nextPageUrl);

                // Initialize components
                initializeFancybox();
                initializeEventHandlers();

                showAlert('success', postsRefreshedText);

                if (typeof callback === 'function') {
                    callback();
                }
            });
        },
        error: function (xhr) {
            console.error('Error refreshing posts:', xhr.responseText);
            showAlert('error', errorRefreshingPostsText);

            if (typeof callback === 'function') {
                callback();
            }
        }
    });
}

/**
 * Get file icon based on file extension
 * @param {string} extension - File extension
 * @returns {string} - Font Awesome icon class
 */
function getFileIcon(extension) {
    switch (extension.toLowerCase()) {
        case 'pdf':
            return 'fa-file-pdf';
        case 'doc':
        case 'docx':
            return 'fa-file-word';
        case 'xls':
        case 'xlsx':
            return 'fa-file-excel';
        case 'ppt':
        case 'pptx':
            return 'fa-file-powerpoint';
        case 'zip':
        case 'rar':
            return 'fa-file-archive';
        case 'txt':
            return 'fa-file-alt';
        default:
            return 'fa-file';
    }
}

// Document ready function
$(document).ready(function () {
    // Get initial next page URL from the data attribute
    nextPageUrl = $('.post-list').data('next-page-url');

    // Initialize components
    initializeFancybox();
    initializeEventHandlers();

    // Enter key handling for post form
    $('#post-form textarea').keydown(function (e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#post-form').submit();
        }
    });

    // Enter key handling for comment forms
    $(document).on('keydown', '.add-comment-form textarea, .reply-comment-form textarea', function (e) {
        if (e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            $(this).closest('form').submit();
        }
    });

    // Hide load more button (using scroll instead)
    $('.load-more').hide();

    // Scroll event to trigger loading more posts
    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 300) {
            if (nextPageUrl && !isLoading) {
                loadMorePosts();
            }
        }

        // Back to top button visibility
        if ($(this).scrollTop() > 300) {
            $('#back-to-top').addClass('visible');
        } else {
            $('#back-to-top').removeClass('visible');
        }
    });

    // Back to top button click handler
    $('#back-to-top').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    // Use Intersection Observer for modern browsers
    if ('IntersectionObserver' in window) {
        const loadingObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && nextPageUrl && !isLoading) {
                    loadMorePosts();
                }
            });
        }, {
            rootMargin: '200px 0px',
        });

        if ($('.loading-indicator').length) {
            loadingObserver.observe($('.loading-indicator')[0]);
        }
    }

    // Refresh button click handler
    $('#refresh-posts').click(function () {
        const $refreshBtn = $(this);

        if ($refreshBtn.hasClass('refreshing')) return;

        $refreshBtn.addClass('refreshing');
        $refreshBtn.find('i').addClass('fa-spin');

        refreshPosts(function () {
            setTimeout(function () {
                $refreshBtn.removeClass('refreshing');
                $refreshBtn.find('i').removeClass('fa-spin');
            }, 500);
        });
    });

    // Pull to refresh functionality
    let touchStartY = 0;
    let touchEndY = 0;
    let isPulling = false;
    const $pullToRefresh = $('.pull-to-refresh');
    const $communityContent = $('.community-content');

    $communityContent.on('touchstart', function (e) {
        if ($(window).scrollTop() <= 10) {
            touchStartY = e.originalEvent.touches[0].clientY;
            isPulling = true;
        }
    });

    $communityContent.on('touchmove', function (e) {
        if (!isPulling) return;

        touchEndY = e.originalEvent.touches[0].clientY;
        const distance = touchEndY - touchStartY;

        if (distance > 0 && $(window).scrollTop() <= 10) {
            const pullHeight = Math.min(distance * 0.5, 60);

            $pullToRefresh.css('height', pullHeight + 'px');

            if (pullHeight >= 60) {
                $pullToRefresh.addClass('active');
                $pullToRefresh.find('.pull-to-refresh-text').text(releaseToRefreshText);
            } else {
                $pullToRefresh.removeClass('active');
                $pullToRefresh.find('.pull-to-refresh-text').text(pullToRefreshText);
            }

            e.preventDefault();
        }
    });

    $communityContent.on('touchend', function () {
        if (!isPulling) return;

        const distance = touchEndY - touchStartY;

        if (distance > 60 && $(window).scrollTop() <= 10) {
            $pullToRefresh.addClass('refreshing');
            $pullToRefresh.removeClass('active');
            $pullToRefresh.find('.pull-to-refresh-icon').removeClass('fa-arrow-down').addClass('fa-sync-alt');
            $pullToRefresh.find('.pull-to-refresh-text').text(refreshingText);

            refreshPosts(function () {
                setTimeout(function () {
                    $pullToRefresh.removeClass('refreshing');
                    $pullToRefresh.css('height', '0');
                    $pullToRefresh.find('.pull-to-refresh-icon').removeClass('fa-sync-alt').addClass('fa-arrow-down');
                    $pullToRefresh.find('.pull-to-refresh-text').text(pullToRefreshText);
                }, 1000);
            });
        } else {
            $pullToRefresh.removeClass('active');
            $pullToRefresh.css('height', '0');
        }

        isPulling = false;
        touchStartY = 0;
        touchEndY = 0;
    });

    // Media upload preview handlers
    $('#image-upload').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#media-preview-content').html(
                    '<img src="' + e.target.result + '" alt="Image preview">');
                $('.media-preview').show();
                $('#post-type').val('image');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#video-upload').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#media-preview-content').html(
                    '<video controls><source src="' + e.target.result + '" type="' + file
                        .type + '">Your browser does not support the video tag.</video>'
                );
                $('.media-preview').show();
                $('#post-type').val('video');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#audio-upload').change(function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#media-preview-content').html(
                    '<audio controls><source src="' + e.target.result + '" type="' + file
                        .type + '">Your browser does not support the audio tag.</audio>'
                );
                $('.media-preview').show();
                $('#post-type').val('audio');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#file-upload').change(function () {
        const file = this.files[0];
        if (file) {
            const extension = file.name.split('.').pop();
            const iconClass = getFileIcon(extension);
            $('#media-preview-content').html(
                `<div class="alert alert-info"><i class="fa ${iconClass}"></i> ${file.name}</div>`
            );
            $('#upload-filename').text(file.name);
            $('.media-preview').show();
            $('#post-type').val('file');
        }
    });

    // Remove media button
    $('#remove-media').click(function () {
        $('.media-preview').hide();
        $('#media-preview-content').html('');
        $('#image-upload, #video-upload, #audio-upload, #file-upload').val('');
        $('#post-type').val('text');
    });

    // Post form submission
    $('#post-form').submit(function (e) {
        e.preventDefault();

        const content = $('textarea[name="content"]').val().trim();
        const hasFile = $('#image-upload').val() || $('#video-upload').val() || $('#audio-upload')
            .val() || $('#file-upload').val();

        if (!content && !hasFile) {
            showAlert('error', pleaseEnterContentText);
            return;
        }

        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text(uploadingText);

        const formData = new FormData(this);

        let activeInput = null;
        if ($('#image-upload').val()) {
            activeInput = $('#image-upload')[0];
            formData.set('media', activeInput.files[0]);
        } else if ($('#video-upload').val()) {
            activeInput = $('#video-upload')[0];
            formData.set('media', activeInput.files[0]);
        } else if ($('#audio-upload').val()) {
            activeInput = $('#audio-upload')[0];
            formData.set('media', activeInput.files[0]);
        } else if ($('#file-upload').val()) {
            activeInput = $('#file-upload')[0];
            formData.set('media', activeInput.files[0]);
        }

        $.ajax({
            url: postStoreUrl,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    // Replace the entire post list instead of prepending
                    $('.post-list').html(response.html);

                    // Update the next page URL after post creation
                    nextPageUrl = $('.post-list').data('next-page-url');

                    // Reinitialize components
                    initializeFancybox();
                    initializeEventHandlers();

                    // Reset form
                    $('#post-form textarea').val('');
                    $('.media-preview').hide();
                    $('#media-preview-content').html('');
                    $('#image-upload, #video-upload, #audio-upload, #file-upload').val('');
                    $('#post-type').val('text');

                    showAlert('success', postCreatedSuccessText);
                } else {
                    showAlert('error', response.message || errorCreatingPostText);
                }

                submitBtn.prop('disabled', false).text(originalText);
            },
            error: function (xhr) {
                console.error(xhr.responseText);

                let errorMessage = errorCreatingPostText;
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    } else if (response.error) {
                        errorMessage = response.error;
                    }

                    if (response.errors && response.errors.media) {
                        errorMessage = response.errors.media[0];
                    }
                } catch (e) {
                    console.error("Error parsing error response:", e);
                }

                showAlert('error', errorMessage);
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Add comment form submission
    $(document).on('submit', '.add-comment-form', function (e) {
        e.preventDefault();

        const form = $(this);
        const postId = form.data('post');
        const content = form.find('textarea').val().trim();

        if (!content) return;

        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: commentStoreUrl,
            type: "POST",
            data: {
                _token: csrfToken,
                post_id: postId,
                content: content
            },
            success: function (response) {
                if (response.success) {
                    const newComment = response.html;
                    $('#comments-' + postId + ' .comments-list').append(newComment);

                    // Update comment count
                    const commentCount = $('#post-' + postId + ' .comments-count');
                    const count = parseInt(commentCount.text()) + 1;
                    commentCount.text(count);

                    form.find('textarea').val('');

                    showAlert('success', commentAddedSuccessText);
                    initializeEventHandlers();
                } else {
                    showAlert('error', response.message || errorAddingCommentText);
                }

                submitBtn.prop('disabled', false).text(originalText);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorAddingCommentText);
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Reply comment form submission
    $(document).on('submit', '.reply-comment-form', function (e) {
        e.preventDefault();

        const form = $(this);
        const postId = form.data('post');
        const parentId = form.data('parent');
        const content = form.find('textarea').val().trim();

        if (!content) return;

        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: commentStoreUrl,
            type: "POST",
            data: {
                _token: csrfToken,
                post_id: postId,
                parent_id: parentId,
                content: content
            },
            success: function (response) {
                if (response.success) {
                    const newReply = response.html;
                    $('#comment-' + parentId + ' .comment-replies').append(newReply);

                    // Update comment count
                    const commentCount = $('#post-' + postId + ' .comments-count');
                    const count = parseInt(commentCount.text()) + 1;
                    commentCount.text(count);

                    form.find('textarea').val('');
                    form.slideUp();

                    showAlert('success', replyAddedSuccessText);
                    initializeEventHandlers();
                } else {
                    showAlert('error', response.message || errorAddingReplyText);
                }

                submitBtn.prop('disabled', false).text(originalText);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorAddingReplyText);
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Edit post button click handler
    $(document).on('click', '.edit-post', function () {
        const postId = $(this).data('id');
        const postContent = $('#post-' + postId + ' .post-text').text().trim();
        const postType = $('#post-' + postId).data('type') || 'text';
        const mediaUrl = $('#post-' + postId).data('media-url') || '';

        const imageUploadId = 'edit-image-upload-' + postId;
        const videoUploadId = 'edit-video-upload-' + postId;
        const audioUploadId = 'edit-audio-upload-' + postId;
        const fileUploadId = 'edit-file-upload-' + postId;
        const mediaPreviewId = 'edit-media-preview-' + postId;
        const mediaPreviewContentId = 'edit-media-preview-content-' + postId;

        const editForm = `
            <div class="edit-post-form">
                <textarea class="post-create-textarea">${postContent}</textarea>
                
                <div class="media-preview" id="${mediaPreviewId}" style="display: none;">
                    <div class="position-relative">
                        <div id="${mediaPreviewContentId}"></div>
                        <div class="media-preview-filename" id="edit-filename-${postId}"></div>
                        <button type="button" class="media-preview-close remove-edit-media" data-target="${mediaPreviewId}">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="upload-buttons-container">
                    <label class="upload-button image" for="${imageUploadId}">
                        <i class="fa fa-image"></i>
                        <span>${photoText}</span>
                        <input type="file" id="${imageUploadId}" name="media" accept="image/*" class="edit-media-upload" data-type="image" data-preview="${mediaPreviewContentId}" data-preview-container="${mediaPreviewId}" data-filename="edit-filename-${postId}" style="display: none;">
                    </label>
                    <label class="upload-button video" for="${videoUploadId}">
                        <i class="fa fa-video"></i>
                        <span>${videoText}</span>
                        <input type="file" id="${videoUploadId}" name="media" accept="video/*" class="edit-media-upload" data-type="video" data-preview="${mediaPreviewContentId}" data-preview-container="${mediaPreviewId}" data-filename="edit-filename-${postId}" style="display: none;">
                    </label>
                    <label class="upload-button audio" for="${audioUploadId}">
                        <i class="fa fa-music"></i>
                        <span>${audioText}</span>
                        <input type="file" id="${audioUploadId}" name="media" accept="audio/*" class="edit-media-upload" data-type="audio" data-preview="${mediaPreviewContentId}" data-preview-container="${mediaPreviewId}" data-filename="edit-filename-${postId}" style="display: none;">
                    </label>
                    <label class="upload-button file" for="${fileUploadId}">
                        <i class="fa fa-file"></i>
                        <span>${fileText}</span>
                        <input type="file" id="${fileUploadId}" name="media" class="edit-media-upload" data-type="file" data-preview="${mediaPreviewContentId}" data-preview-container="${mediaPreviewId}" data-filename="edit-filename-${postId}" style="display: none;">
                    </label>
                </div>
                
                <div class="edit-actions">
                    <button type="button" class="btn-cancel cancel-edit-post">${cancelText}</button>
                    <button type="button" class="btn-save save-edit-post" data-id="${postId}">${saveText}</button>
                </div>
                
                <input type="hidden" id="edit-post-type-${postId}" value="${postType}">
                <input type="hidden" id="edit-media-changed-${postId}" value="0">
            </div>
        `;

        $('#post-' + postId + ' .post-text').html(editForm);

        if (mediaUrl && postType !== 'text') {
            let mediaPreviewHtml = '';
            const mediaFullUrl = mediaBaseUrl + "/" + mediaUrl;
            const fileName = mediaUrl.split('/').pop();

            if (postType === 'image') {
                mediaPreviewHtml = `<img src="${mediaFullUrl}" alt="Image preview">`;
            } else if (postType === 'video') {
                mediaPreviewHtml =
                    `<video controls><source src="${mediaFullUrl}" type="video/mp4">Your browser does not support the video tag.</video>`;
            } else if (postType === 'audio') {
                mediaPreviewHtml =
                    `<audio controls><source src="${mediaFullUrl}" type="audio/mpeg">Your browser does not support the audio tag.</audio>`;
            } else if (postType === 'file') {
                mediaPreviewHtml =
                    `<div class="alert alert-info"><i class="fa fa-file"></i> ${fileName}</div>`;
            }

            $(`#${mediaPreviewContentId}`).html(mediaPreviewHtml);
            $(`#edit-filename-${postId}`).text(fileName);
            $(`#${mediaPreviewId}`).show();
        }

        $('.post-options-menu').removeClass('show');
    });

    // Edit media upload change handler
    $(document).on('change', '.edit-media-upload', function () {
        const file = this.files[0];
        if (!file) return;

        const mediaType = $(this).data('type');
        const previewContentId = $(this).data('preview');
        const previewContainerId = $(this).data('preview-container');
        const filenameId = $(this).data('filename');
        const postId = $(this).closest('.edit-post-form').find('.save-edit-post').data('id');

        $(`#edit-post-type-${postId}`).val(mediaType);
        $(`#edit-media-changed-${postId}`).val('1');

        const reader = new FileReader();
        reader.onload = function (e) {
            let previewHtml = '';

            if (mediaType === 'image') {
                previewHtml = `<img src="${e.target.result}" alt="Image preview">`;
            } else if (mediaType === 'video') {
                previewHtml =
                    `<video controls><source src="${e.target.result}" type="${file.type}">Your browser does not support the video tag.</video>`;
            } else if (mediaType === 'audio') {
                previewHtml =
                    `<audio controls><source src="${e.target.result}" type="${file.type}">Your browser does not support the audio tag.</audio>`;
            } else if (mediaType === 'file') {
                const extension = file.name.split('.').pop();
                const iconClass = getFileIcon(extension);
                previewHtml =
                    `<div class="alert alert-info"><i class="fa ${iconClass}"></i> ${file.name}</div>`;
            }

            $(`#${previewContentId}`).html(previewHtml);
            $(`#${filenameId}`).text(file.name);
            $(`#${previewContainerId}`).show();
        };

        reader.readAsDataURL(file);
    });

    // Cancel edit post button
    $(document).on('click', '.btn-cancel, .cancel-edit-post', function () {
        const postText = $(this).closest('.post-text');
        const originalContent = postText.find('textarea').val();
        postText.text(originalContent);
    });

    // Save edit post button
    $(document).on('click', '.save-edit-post', function () {
        const postId = $(this).data('id');
        const content = $(this).closest('.edit-post-form').find('textarea').val().trim();
        const postType = $(`#edit-post-type-${postId}`).val();
        const mediaChanged = $(`#edit-media-changed-${postId}`).val() === '1';

        const saveBtn = $(this);
        const originalText = saveBtn.text();
        saveBtn.prop('disabled', true).text(savingText);

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('_method', 'PUT');
        formData.append('content', content);
        formData.append('type', postType);

        if (mediaChanged) {
            let mediaInput = null;

            if (postType === 'image') {
                mediaInput = $(`#edit-image-upload-${postId}`)[0];
            } else if (postType === 'video') {
                mediaInput = $(`#edit-video-upload-${postId}`)[0];
            } else if (postType === 'audio') {
                mediaInput = $(`#edit-audio-upload-${postId}`)[0];
            } else if (postType === 'file') {
                mediaInput = $(`#edit-file-upload-${postId}`)[0];
            }

            if (mediaInput && mediaInput.files[0]) {
                formData.append('media', mediaInput.files[0]);
            } else if (mediaChanged && postType === 'text') {
                formData.append('remove_media', '1');
            }
        }

        $.ajax({
            url: postUpdateUrl.replace(':id', postId),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    location.reload();
                } else {
                    showAlert('error', response.message || errorUpdatingPostText);
                    saveBtn.prop('disabled', false).text(originalText);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);

                let errorMessage = errorUpdatingPostText;
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    } else if (response.error) {
                        errorMessage = response.error;
                    }

                    if (response.errors && response.errors.media) {
                        errorMessage = response.errors.media[0];
                    }
                } catch (e) {
                    console.error("Error parsing error response:", e);
                }

                showAlert('error', errorMessage);
                saveBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Delete post button
    $(document).on('click', '.delete-post', function () {
        if (!confirm(confirmDeletePostText)) return;

        const postId = $(this).data('id');

        $.ajax({
            url: postDestroyUrl.replace(':post', postId),
            type: "DELETE",
            data: {
                _token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    $('#post-' + postId).fadeOut(function () {
                        $(this).remove();
                    });
                    showAlert('success', response.message || 'Post deleted successfully');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorDeletingPostText);
            }
        });

        $('.post-options-menu').removeClass('show');
    });

    // Pin post button
    $(document).on('click', '.pin-post', function () {
        const postId = $(this).data('id');

        $.ajax({
            url: postPinUrl.replace(':id', postId),
            type: "POST",
            data: {
                _token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    location.reload();
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorPinningPostText);
            }
        });

        $('.post-options-menu').removeClass('show');
    });

    // Edit comment button
    $(document).on('click', '.edit-comment', function () {
        const commentId = $(this).data('id');
        const commentContent = $('#comment-' + commentId + ' .comment-text').text().trim();

        const editForm = `
            <div class="edit-comment-form">
                <textarea class="comment-create-textarea">${commentContent}</textarea>
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-secondary cancel-edit-comment">${cancelText}</button>
                    <button type="button" class="btn btn-sm btn-primary save-edit-comment" data-id="${commentId}">${saveText}</button>
                </div>
            </div>
        `;

        $('#comment-' + commentId + ' .comment-text').html(editForm);
    });

    // Cancel edit comment button
    $(document).on('click', '.cancel-edit-comment', function () {
        const commentText = $(this).closest('.comment-text');
        const originalContent = commentText.find('textarea').val();
        commentText.text(originalContent);
    });

    // Save edit comment button
    $(document).on('click', '.save-edit-comment', function () {
        const commentId = $(this).data('id');
        const content = $(this).closest('.edit-comment-form').find('textarea').val().trim();

        if (!content) {
            showAlert('error', 'Comment cannot be empty');
            return;
        }

        const saveBtn = $(this);
        const originalText = saveBtn.text();
        saveBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: commentUpdateUrl.replace(':comment', commentId),
            type: "PUT",
            data: {
                _token: csrfToken,
                content: content
            },
            success: function (response) {
                if (response.success) {
                    $('#comment-' + commentId + ' .comment-text').text(content);
                    showAlert('success', 'Comment updated successfully');
                } else {
                    showAlert('error', response.message || errorUpdatingCommentText);
                }
                saveBtn.prop('disabled', false).text(originalText);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorUpdatingCommentText);
                saveBtn.prop('disabled', false).text(originalText);
            }
        });
    });

    // Delete comment button
    $(document).on('click', '.delete-comment', function () {
        if (!confirm(confirmDeleteCommentText)) return;

        const commentId = $(this).data('id');
        const postId = $(this).data('post');

        $.ajax({
            url: commentDestroyUrl.replace(':comment', commentId),
            type: "DELETE",
            data: {
                _token: csrfToken
            },
            success: function (response) {
                if (response.success) {
                    $('#comment-' + commentId).fadeOut(function () {
                        $(this).remove();

                        // Update comment count
                        if (postId) {
                            const commentCount = $('#post-' + postId + ' .comments-count');
                            const count = parseInt(commentCount.text()) - 1;
                            commentCount.text(Math.max(0, count));
                        }
                    });

                    showAlert('success', 'Comment deleted successfully');
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorDeletingCommentText);
            }
        });
    });

    // Like post button
    $(document).on('click', '.like-post', function () {
        const postId = $(this).data('id');
        const likeButton = $(this);

        $.ajax({
            url: postLikeUrl.replace(':post', postId),
            type: "POST",
            data: {
                _token: csrfToken,
                likeable_id: postId,
                likeable_type: 'post'
            },
            success: function (response) {
                if (response.success) {
                    likeButton.find('.likes-count').text(response.likes_count);

                    if (response.liked === true) {
                        likeButton.addClass('liked');
                    } else {
                        likeButton.removeClass('liked');
                    }
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorLikingPostText);
            }
        });
    });

    // Like comment button
    $(document).on('click', '.like-comment', function () {
        const commentId = $(this).data('id');
        const likeButton = $(this);

        $.ajax({
            url: commentLikeUrl.replace(':comment', commentId),
            type: "POST",
            data: {
                _token: csrfToken,
                likeable_id: commentId,
                likeable_type: 'comment'
            },
            success: function (response) {
                if (response.success) {
                    likeButton.find('.likes-count').text(response.likes_count);

                    if (response.liked === true) {
                        likeButton.addClass('liked');
                    } else {
                        likeButton.removeClass('liked');
                    }
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                showAlert('error', errorLikingCommentText);
            }
        });
    });

    // Close post options menu when clicking outside
    $(document).on('click', function () {
        $('.post-options-menu').removeClass('show');
    });

    // Prevent closing post options menu when clicking inside it
    $(document).on('click', '.post-options-menu', function (e) {
        e.stopPropagation();
    });

    // Remove edit media button
    $(document).on('click', '.remove-edit-media', function () {
        const targetId = $(this).data('target');
        $(`#${targetId}`).hide();
        const postId = $(this).closest('.edit-post-form').find('.save-edit-post').data('id');
        $(`#edit-post-type-${postId}`).val('text');
        $(`#edit-media-changed-${postId}`).val('1');
    });

    // Initialize Pusher for real-time updates if available
    if (typeof Pusher !== 'undefined' && pusherAppKey) {
        const pusher = new Pusher(pusherAppKey, {
            cluster: pusherAppCluster,
            encrypted: true
        });

        const channel = pusher.subscribe(`community.${communityId}`);

        // New post event
        channel.bind('new-post', function (data) {
            if (data.user_id !== currentUserId) {
                // Show notification for new post
                showAlert('info', 'New post available. Pull to refresh.');

                // Add refresh button at the top if not exists
                if ($('.refresh-notification').length === 0) {
                    $('.post-list').prepend(`
                        <div class="refresh-notification">
                            <button class="btn btn-primary refresh-btn">
                                <i class="fa fa-sync-alt"></i> New posts available. Click to refresh.
                            </button>
                        </div>
                    `);
                }
            }
        });

        // New comment event
        channel.bind('new-comment', function (data) {
            if (data.user_id !== currentUserId) {
                // If the comments section for this post is open, append the new comment
                if ($(`#comments-${data.post_id}`).is(':visible')) {
                    // Fetch the new comment via AJAX and append it
                    $.get(`/community/comment/${data.comment_id}`, function (response) {
                        if (response.success) {
                            if (data.parent_id) {
                                $(`#comment-${data.parent_id} .comment-replies`).append(response.html);
                            } else {
                                $(`#comments-${data.post_id} .comments-list`).append(response.html);
                            }

                            // Update comment count
                            const commentCount = $(`#post-${data.post_id} .comments-count`);
                            const count = parseInt(commentCount.text()) + 1;
                            commentCount.text(count);

                            initializeEventHandlers();
                        }
                    });
                } else {
                    // Just update the comment count
                    const commentCount = $(`#post-${data.post_id} .comments-count`);
                    const count = parseInt(commentCount.text()) + 1;
                    commentCount.text(count);
                }
            }
        });
    }

    // Click handler for refresh notification button
    $(document).on('click', '.refresh-btn', function () {
        refreshPosts(function () {
            $('.refresh-notification').remove();
        });
    });
});


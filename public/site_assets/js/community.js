// التعامل مع إنشاء المنشورات
$(document).ready(function () {
    // معاينة الصورة قبل الرفع
    $('#media-upload').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('.create-post-media-preview').html('<img src="' + e.target.result + '" alt="معاينة الصورة">').show();
            }
            reader.readAsDataURL(file);
        }
    });

    // إرسال نموذج إنشاء المنشور
    $('#create-post-form').on('submit', function (e) {
        e.preventDefault();

        const content = $('#post-content').val();
        if (!content.trim()) {
            alert('يرجى كتابة محتوى المنشور');
            return;
        }

        const formData = new FormData(this);
        const submitBtn = $('#create-post-submit');
        submitBtn.prop('disabled', true).text('جاري النشر...');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // إعادة تحميل الصفحة لعرض المنشور الجديد
                    window.location.reload();
                } else {
                    alert('حدث خطأ أثناء نشر المنشور');
                    submitBtn.prop('disabled', false).text('نشر');
                }
            },
            error: function () {
                alert('حدث خطأ أثناء نشر المنشور');
                submitBtn.prop('disabled', false).text('نشر');
            }
        });
    });

    // إضافة تعليق على منشور
    $('.comment-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const postId = form.data('post-id');
        const content = form.find('textarea').val();

        if (!content.trim()) {
            return;
        }

        $.ajax({
            url: '/community/comment',
            type: 'POST',
            data: {
                post_id: postId,
                content: content,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // إعادة تحميل الصفحة لعرض التعليق الجديد
                    window.location.reload();
                } else {
                    alert('حدث خطأ أثناء إضافة التعليق');
                }
            },
            error: function () {
                alert('حدث خطأ أثناء إضافة التعليق');
            }
        });
    });

    // إظهار نموذج الرد على التعليق
    $('.comment-action.reply').on('click', function () {
        const commentId = $(this).data('comment-id');
        const replyForm = $(this).closest('.comment').find('.reply-form');
        replyForm.toggle();
    });

    // إرسال رد على تعليق
    $('.reply-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const postId = form.data('post-id');
        const parentId = form.data('comment-id');
        const content = form.find('textarea').val();

        if (!content.trim()) {
            return;
        }

        $.ajax({
            url: '/community/comment',
            type: 'POST',
            data: {
                post_id: postId,
                parent_id: parentId,
                content: content,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // إعادة تحميل الصفحة لعرض الرد الجديد
                    window.location.reload();
                } else {
                    alert('حدث خطأ أثناء إضافة الرد');
                }
            },
            error: function () {
                alert('حدث خطأ أثناء إضافة الرد');
            }
        });
    });
});

// دالة الإعجاب بمنشور
function likePost(postId) {
    $.ajax({
        url: '/community/post/' + postId + '/like',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const likeElement = $('.post-stat.like[data-post-id="' + postId + '"]');
                const likesCount = likeElement.find('.likes-count');

                if (response.liked) {
                    likeElement.addClass('liked');
                    likesCount.text(parseInt(likesCount.text()) + 1);
                } else {
                    likeElement.removeClass('liked');
                    likesCount.text(parseInt(likesCount.text()) - 1);
                }
            }
        }
    });
}

// دالة الإعجاب بتعليق
function likeComment(commentId) {
    $.ajax({
        url: '/community/comment/' + commentId + '/like',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const likeElement = $('.comment-stat.like[data-comment-id="' + commentId + '"]');
                const likesCount = likeElement.find('.likes-count');

                if (response.liked) {
                    likeElement.addClass('liked');
                    likesCount.text(parseInt(likesCount.text()) + 1);
                } else {
                    likeElement.removeClass('liked');
                    likesCount.text(parseInt(likesCount.text()) - 1);
                }
            }
        }
    });
}

// دالة حذف منشور
function deletePost(postId) {
    if (confirm('هل أنت متأكد من حذف هذا المنشور؟')) {
        $.ajax({
            url: '/community/post/' + postId,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    alert('حدث خطأ أثناء حذف المنشور');
                }
            },
            error: function () {
                alert('حدث خطأ أثناء حذف المنشور');
            }
        });
    }
}

// دالة حذف تعليق
function deleteComment(commentId) {
    if (confirm('هل أنت متأكد من حذف هذا التعليق؟')) {
        $.ajax({
            url: '/community/comment/' + commentId,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    window.location.reload();
                } else {
                    alert('حدث خطأ أثناء حذف التعليق');
                }
            },
            error: function () {
                alert('حدث خطأ أثناء حذف التعليق');
            }
        });
    }
}

// دالة تثبيت منشور
function pinPost(postId) {
    $.ajax({
        url: '/community/post/' + postId + '/pin',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                window.location.reload();
            } else {
                alert('حدث خطأ أثناء تثبيت المنشور');
            }
        },
        error: function () {
            alert('حدث خطأ أثناء تثبيت المنشور');
        }
    });
}

// دالة الدردشة المباشرة
$(document).ready(function () {
    // إذا كنا في صفحة الدردشة
    if ($('.chat-container').length > 0) {
        const communityId = $('.chat-container').data('community-id');
        const userId = $('.chat-container').data('user-id');
        const chatMessages = $('.chat-messages');

        // تمرير إلى آخر الرسائل
        chatMessages.scrollTop(chatMessages[0].scrollHeight);

        // إرسال رسالة جديدة
        $('#send-message').on('click', function () {
            sendMessage();
        });

        // إرسال الرسالة عند الضغط على Enter
        $('#message-input').on('keypress', function (e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        function sendMessage() {
            const messageInput = $('#message-input');
            const content = messageInput.val();

            if (!content.trim()) {
                return;
            }

            $.ajax({
                url: '/community/' + communityId + '/chat/send',
                type: 'POST',
                data: {
                    content: content,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // إضافة الرسالة إلى الدردشة
                        const message = response.message;
                        const messageHtml = `
                            <div class="chat-message sent" data-message-id="${message.id}">
                                <div class="message-avatar">
                                    <img src="${message.user_image}" alt="${message.user_name}">
                                </div>
                                <div class="message-content">
                                    <div class="message-header">
                                        <span class="message-username">${message.user_name}</span>
                                        <span class="message-time">${message.time}</span>
                                    </div>
                                    <div class="message-text">${message.content}</div>
                                </div>
                            </div>
                        `;

                        chatMessages.append(messageHtml);
                        chatMessages.scrollTop(chatMessages[0].scrollHeight);
                        messageInput.val('');
                    }
                }
            });
        }

        // تحديث الدردشة كل 5 ثوانٍ
        setInterval(function () {
            const lastMessageId = $('.chat-message').last().data('message-id') || 0;

            $.ajax({
                url: '/community/' + communityId + '/chat/messages',
                type: 'GET',
                data: {
                    last_id: lastMessageId
                },
                success: function (response) {
                    if (response.messages && response.messages.length > 0) {
                        response.messages.forEach(function (message) {
                            const messageHtml = `
                                <div class="chat-message ${message.user_id == userId ? 'sent' : 'received'}" data-message-id="${message.id}">
                                    <div class="message-avatar">
                                        <img src="${message.user_image}" alt="${message.user_name}">
                                    </div>
                                    <div class="message-content">
                                        <div class="message-header">
                                            <span class="message-username">${message.user_name}</span>
                                            <span class="message-time">${message.time}</span>
                                        </div>
                                        <div class="message-text">${message.content}</div>
                                    </div>
                                </div>
                            `;

                            chatMessages.append(messageHtml);
                        });

                        chatMessages.scrollTop(chatMessages[0].scrollHeight);
                    }
                }
            });
        }, 5000);

        // تحديث حالة المستخدمين المتصلين
        setInterval(function () {
            $.ajax({
                url: '/community/' + communityId + '/chat/online-users',
                type: 'GET',
                success: function (response) {
                    if (response.users) {
                        // تحديث حالة كل مستخدم في القائمة
                        $('.chat-user').each(function () {
                            const userId = $(this).data('user-id');
                            if (response.users.includes(userId)) {
                                $(this).addClass('online').removeClass('offline');
                                $(this).find('.chat-user-status').html('<span class="online-indicator"></span> متصل الآن');
                            } else {
                                $(this).addClass('offline').removeClass('online');
                                $(this).find('.chat-user-status').html('<span class="offline-indicator"></span> غير متصل');
                            }
                        });

                        // تحديث عدد المستخدمين المتصلين
                        $('.online-users-count').text(response.users.length);
                    }
                }
            });
        }, 30000); // تحديث كل 30 ثانية
    }
});
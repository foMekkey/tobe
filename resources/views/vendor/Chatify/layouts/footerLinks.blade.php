<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@3.0.3/dist/index.min.js"></script>
<script>
    // Gloabl Chatify variables from PHP to JS
    window.chatify = {
        name: "{{ config('chatify.name') }}",
        sounds: {!! json_encode(config('chatify.sounds')) !!},
        allowedImages: {!! json_encode(config('chatify.attachments.allowed_images')) !!},
        allowedFiles: {!! json_encode(config('chatify.attachments.allowed_files')) !!},
        maxUploadSize: {{ Chatify::getMaxUploadSize() }},
        pusher: {!! json_encode(config('chatify.pusher')) !!},
        pusherAuthEndpoint: '{{ route('pusher.auth') }}'
    };
    window.chatify.allAllowedExtensions = chatify.allowedImages.concat(chatify.allowedFiles);


    // إضافة زر "All Users" بعد زر "All Messages"
    $('.messenger-listView-tabs').append('<a href="#" class="all-users-tab">All Users</a>');

    // إضافة معالج النقر على زر "All Users"
    $('.all-users-tab').on('click', function() {
        $('.messenger-tab').removeClass('active-tab');
        $(this).addClass('active-tab');

        // تغيير العنوان
        $('.messenger-listView-tabs .m-header-messaging').text('All Users');

        // إظهار مؤشر التحميل
        $('.messenger-listView').append('<div class="messenger-loading-users"><span></span></div>');

        // جلب جميع المستخدمين
        $.ajax({
            url: url + '/getAllUsers',
            method: 'GET',
            data: {
                '_token': access_token
            },
            dataType: 'JSON',
            success: (data) => {
                // إزالة مؤشر التحميل
                $('.messenger-loading-users').remove();

                // إضافة المستخدمين إلى القائمة
                $('.messenger-list').html(data.users);

                // تحديث عدد الصفحات
                messagesContainer.find('.messenger-list').find('svg').remove();
                messagesContainer.find('.messenger-list').append('<svg><defs></defs></svg>');

                // إضافة معالج التمرير لتحميل المزيد من المستخدمين
                $('.messenger-list').scroll(function() {
                    var container = $(this);
                    var position = container.scrollTop() + container.height();
                    var height = container[0].scrollHeight;

                    if (position >= height && !noMoreUsers && loadingUsers == 0) {
                        loadMoreUsers(data.last_page);
                    }
                });
            },
            error: () => {
                console.error('Error fetching users');
                // إزالة مؤشر التحميل
                $('.messenger-loading-users').remove();
            }
        });

        return false;
    });

    // متغيرات لتحميل المزيد من المستخدمين
    var noMoreUsers = false;
    var usersPage = 1;
    var loadingUsers = 0;

    // دالة لتحميل المزيد من المستخدمين عند التمرير
    function loadMoreUsers(last_page) {
        if (usersPage >= last_page) {
            noMoreUsers = true;
            return;
        }

        loadingUsers = 1;
        usersPage++;

        $.ajax({
            url: url + '/getAllUsers',
            method: 'GET',
            data: {
                '_token': access_token,
                'page': usersPage
            },
            dataType: 'JSON',
            success: (data) => {
                loadingUsers = 0;

                // إضافة المستخدمين الجدد إلى القائمة
                $('.messenger-list').append(data.users);

                // تحديث حالة تحميل المزيد
                if (usersPage >= last_page) {
                    noMoreUsers = true;
                }
            },
            error: () => {
                console.error('Error fetching more users');
                loadingUsers = 0;
            }
        });
    }
</script>
<script src="{{ asset('js/chatify/utils.js') }}"></script>
<script src="{{ asset('js/chatify/code.js') }}"></script>

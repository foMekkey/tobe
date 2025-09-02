@extends('site.layouts.app')

@section('styles')
    <style>
        .chat-container {
            display: flex;
            height: calc(100vh - 200px);
            margin: 30px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .chat-sidebar {
            width: 250px;
            background-color: #f5f5f5;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px;
            background-color: #FF7F00;
            color: #fff;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-header h3 {
            margin: 0;
            font-size: 18px;
        }

        .chat-members {
            flex-grow: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .chat-member {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }

        .chat-member:hover {
            background-color: #e0e0e0;
        }

        .chat-member.online {
            background-color: rgba(76, 175, 80, 0.1);
        }

        .chat-member-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
            position: relative;
        }

        .chat-member-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .chat-member-status {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #f5f5f5;
        }

        .chat-member-status.online {
            background-color: #4CAF50;
        }

        .chat-member-status.offline {
            background-color: #9e9e9e;
        }

        .chat-member-info {
            flex-grow: 1;
        }

        .chat-member-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
        }

        .chat-member-role {
            font-size: 12px;
            color: #777;
        }

        .chat-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }

        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .chat-message {
            max-width: 70%;
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .chat-message.sent {
            align-self: flex-end;
        }

        .chat-message.received {
            align-self: flex-start;
        }

        .chat-message-content {
            padding: 10px 15px;
            border-radius: 10px;
            position: relative;
        }

        .chat-message.sent .chat-message-content {
            background-color: #FF7F00;
            color: #fff;
            border-bottom-right-radius: 0;
        }

        .chat-message.received .chat-message-content {
            background-color: #f1f1f1;
            color: #333;
            border-bottom-left-radius: 0;
        }

        .chat-message-text {
            margin-bottom: 5px;
            white-space: pre-line;
        }

        .chat-message-time {
            font-size: 11px;
            opacity: 0.7;
            text-align: right;
        }

        .chat-message-info {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .chat-message-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 10px;
        }

        .chat-message-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .chat-message-sender {
            font-weight: bold;
            font-size: 13px;
            color: #555;
        }

        .chat-input {
            padding: 15px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }

        .chat-input-textarea {
            flex-grow: 1;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            padding: 10px 15px;
            resize: none;
            min-height: 40px;
            max-height: 100px;
            overflow-y: auto;
        }

        .chat-input-textarea:focus {
            outline: none;
            border-color: #FF7F00;
        }

        .chat-input-actions {
            display: flex;
            margin-left: 10px;
        }

        .chat-input-action {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            color: #555;
            margin-left: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chat-input-action:hover {
            background-color: #e0e0e0;
        }

        .chat-input-action.send {
            background-color: #FF7F00;
            color: #fff;
        }

        .chat-input-action.send:hover {
            background-color: #e67300;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chat-container {
                flex-direction: column;
                height: calc(100vh - 150px);
            }

            .chat-sidebar {
                width: 100%;
                height: 200px;
            }

            .chat-main {
                height: calc(100vh - 350px);
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="chat-container">
            <div class="chat-sidebar">
                <div class="chat-header">
                    <h3>{{ $community->name }}</h3>
                    <a href="{{ route('community.show', $community->id) }}" class="text-white">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </div>
                <div class="chat-members">
                    @foreach ($members as $member)
                        <div class="chat-member {{ $member->is_online ? 'online' : '' }}">
                            <div class="chat-member-avatar">
                                @if ($member->image)
                                    <img src="{{ asset('uploads/' . $member->image) }}" alt="{{ $member->user_name }}">
                                @else
                                    <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                        alt="{{ $member->user_name }}">
                                @endif
                                <div class="chat-member-status {{ $member->is_online ? 'online' : 'offline' }}"></div>
                            </div>
                            <div class="chat-member-info">
                                <div class="chat-member-name">{{ $member->user_name }}</div>
                                <div class="chat-member-role">
                                    @if ($member->role == 1)
                                        {{ __('site.admin') }}
                                    @elseif($member->role == 2)
                                        {{ __('site.trainer') }}
                                    @else
                                        {{ __('site.trainee') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="chat-main">
                <div class="chat-messages" id="chat-messages">
                    @foreach ($messages as $message)
                        <div class="chat-message {{ $message->user_id == Auth::id() ? 'sent' : 'received' }}">
                            @if ($message->user_id != Auth::id())
                                <div class="chat-message-info">
                                    <div class="chat-message-avatar">
                                        @if ($message->user->image)
                                            <img src="{{ asset('uploads/' . $message->user->image) }}"
                                                alt="{{ $message->user->user_name }}">
                                        @else
                                            <img src="{{ asset('admin/assets/media/users/300_21.jpg') }}"
                                                alt="{{ $message->user->user_name }}">
                                        @endif
                                    </div>
                                    <div class="chat-message-sender">{{ $message->user->user_name }}</div>
                                </div>
                            @endif
                            <div class="chat-message-content">
                                <div class="chat-message-text">{{ $message->content }}</div>
                                <div class="chat-message-time">{{ $message->created_at->format('h:i A') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="chat-input">
                    <textarea class="chat-input-textarea" id="message-input" placeholder="{{ __('site.type_a_message') }}"></textarea>
                    <div class="chat-input-actions">
                        <div class="chat-input-action send" id="send-message">
                            <i class="fa fa-paper-plane"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // التمرير إلى آخر الرسائل
            var chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // إرسال رسالة عند الضغط على زر الإرسال
            $('#send-message').click(function() {
                sendMessage();
            });

            // إرسال رسالة عند الضغط على Enter
            $('#message-input').keypress(function(e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            function sendMessage() {
                var content = $('#message-input').val().trim();
                if (!content) return;

                $.ajax({
                    url: "{{ route('community.chat.send', ':community') }}".replace(':community',
                        {{ $community->id }}),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        community_id: {{ $community->id }},
                        content: content
                    },
                    success: function(response) {
                        if (response.success) {
                            // إضافة الرسالة إلى الدردشة
                            var message = `
                                    <div class="chat-message sent">
                                        <div class="chat-message-content">
                                            <div class="chat-message-text">${content}</div>
                                            <div class="chat-message-time">${response.time}</div>
                                        </div>
                                    </div>
                                `;

                            $('#chat-messages').append(message);

                            // التمرير إلى آخر الرسائل
                            chatMessages.scrollTop = chatMessages.scrollHeight;

                            // مسح محتوى مربع النص
                            $('#message-input').val('');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("{{ __('site.error_sending_message') }}");
                    }
                });
            }

            // جلب الرسائل الجديدة كل 5 ثوانٍ
            setInterval(function() {
                getNewMessages();
            }, 5000);

            function getNewMessages() {
                var lastMessageId = $('.chat-message').last().data('id') || 0;
                var communityId = {{ $community->id }};
                $.ajax({
                    url: "{{ route('community.chat.messages', ':community') }}".replace(':community',
                        communityId),
                    type: "GET",
                    data: {
                        community_id: {{ $community->id }},
                        last_id: lastMessageId
                    },
                    success: function(response) {
                        if (response.messages && response.messages.length > 0) {
                            response.messages.forEach(function(message) {
                                if (message.user_id != {{ Auth::id() }}) {
                                    var newMessage = `
                                            <div class="chat-message received" data-id="${message.id}">
                                                <div class="chat-message-info">
                                                    <div class="chat-message-avatar">
                                                        <img src="${message.user_image}" alt="${message.user_name}">
                                                    </div>
                                                    <div class="chat-message-sender">${message.user_name}</div>
                                                </div>
                                                <div class="chat-message-content">
                                                    <div class="chat-message-text">${message.content}</div>
                                                    <div class="chat-message-time">${message.time}</div>
                                                </div>
                                            </div>
                                        `;

                                    $('#chat-messages').append(newMessage);

                                    // التمرير إلى آخر الرسائل
                                    chatMessages.scrollTop = chatMessages.scrollHeight;
                                }
                            });

                            // تحديث حالة القراءة
                            $.ajax({
                                url: "{{ route('message.read') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    community_id: {{ $community->id }}
                                }
                            });
                        }
                    }
                });
            }
        });
    </script>
@endsection

@extends('backend.layouts.app')
@section('page-main-title', $group->name . ' Chat')

@section('styles')
    <style>
        .chat-container {
            display: flex;
            height: calc(100vh - 200px);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .chat-sidebar {
            width: 280px;
            background: #f5f5f5;
            border-right: 1px solid #e0e0e0;
            overflow-y: auto;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
        }

        .chat-header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .chat-header-info h4 {
            margin: 0;
            font-size: 16px;
        }

        .chat-header-info p {
            margin: 0;
            font-size: 12px;
            color: #8e8e8e;
        }

        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
        }

        .message.outgoing {
            justify-content: flex-end;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .message.outgoing .message-avatar {
            display: none;
        }

        .message-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 18px;
            background: #f1f0f0;
        }

        .message.outgoing .message-bubble {
            background: #0084ff;
            color: white;
        }

        .message-info {
            font-size: 12px;
            color: #8e8e8e;
            margin-top: 5px;
        }

        .message.outgoing .message-info {
            text-align: right;
            color: #ccc;
        }

        .chat-input {
            padding: 15px;
            border-top: 1px solid #e0e0e0;
        }

        .chat-input form {
            display: flex;
        }

        .chat-input input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #dbdbdb;
            border-radius: 24px;
            outline: none;
        }

        .chat-input button {
            margin-left: 10px;
            border-radius: 24px;
        }

        .user-list-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
            cursor: pointer;
        }

        .user-list-item:hover {
            background: #efefef;
        }

        .user-list-item.active {
            background: #e1f5fe;
        }

        .user-list-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-list-info h4 {
            margin: 0;
            font-size: 14px;
        }

        .user-list-info p {
            margin: 0;
            font-size: 12px;
            color: #8e8e8e;
        }
    </style>
@endsection

@section('content')
    <div class="chat-container">
        <div class="chat-sidebar">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">Group Members</h5>
            </div>
            @foreach ($group->members as $member)
                <div class="user-list-item" onclick="location.href='{{ route('chat.private', $member->id) }}'">
                    <img src="{{ $member->avatar ?? asset('site_assets/images/default-avatar.png') }}"
                        class="user-list-avatar">
                    <div class="user-list-info">
                        <h4>{{ $member->name }}</h4>
                        <p>{{ $member->role }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="chat-main">
            <div class="chat-header">
                <img src="{{ asset('site_assets/images/group-avatar.png') }}" class="chat-header-avatar">
                <div class="chat-header-info">
                    <h4>{{ $group->name }}</h4>
                    <p>{{ $group->members->count() }} members</p>
                </div>
            </div>

            <div class="chat-messages" id="chat-messages">
                @foreach ($messages as $message)
                    <div class="message {{ $message->sender_id == auth()->id() ? 'outgoing' : '' }}">
                        @if ($message->sender_id != auth()->id())
                            <img src="{{ $message->sender->avatar ?? asset('site_assets/images/default-avatar.png') }}"
                                class="message-avatar">
                        @endif
                        <div>
                            <div class="message-bubble">
                                {{ $message->message }}
                            </div>
                            <div class="message-info">
                                {{ $message->sender->name }} • {{ $message->created_at->format('h:i A') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="chat-input">
                <form id="message-form">
                    @csrf
                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                    <input type="text" name="message" placeholder="Type a message..." autocomplete="off">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Scroll to bottom of chat
        function scrollToBottom() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Scroll on page load
        document.addEventListener('DOMContentLoaded', scrollToBottom);

        // Handle form submission
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('chat.send') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.reset();
                        // The message will be added via Pusher
                    }
                });
        });

        // Set up Pusher for real-time messaging
        const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        const channel = pusher.subscribe('group-chat-{{ $group->id }}');
        channel.bind('new-message', function(data) {
            const chatMessages = document.getElementById('chat-messages');

            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${data.message.sender_id == {{ auth()->id() }} ? 'outgoing' : ''}`;

            let html = '';
            if (data.message.sender_id != {{ auth()->id() }}) {
                html += `<img src="${data.sender_avatar}" class="message-avatar">`;
            }

            html += `
            <div>
                <div class="message-bubble">
                    ${data.message.message}
                </div>
                <div class="message-info">
                    ${data.sender_name} • ${data.time}
                </div>
            </div>
        `;

            messageDiv.innerHTML = html;
            chatMessages.appendChild(messageDiv);

            scrollToBottom();
        });
    </script>
@endsection

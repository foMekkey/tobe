<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    public $time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
        $this->sender = $message->sender;
        $this->time = $message->created_at->format('h:i A');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        if ($this->message->group_id) {
            return new Channel('group-chat-' . $this->message->group_id);
        } else {
            return [
                new PrivateChannel('private-chat-' . $this->message->sender_id . '-' . $this->message->receiver_id),
                new PrivateChannel('private-chat-' . $this->message->receiver_id . '-' . $this->message->sender_id)
            ];
        }
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'new-message';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'sender_name' => $this->sender->name,
            'sender_avatar' => $this->sender->avatar ?? asset('site_assets/images/default-avatar.png'),
            'time' => $this->time
        ];
    }
}

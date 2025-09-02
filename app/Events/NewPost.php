<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Post;

class NewPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;
    public $html;
    public $communityId;

    public function __construct(Post $post, $html)
    {
        $this->post = $post;
        $this->html = $html;
        $this->communityId = $post->community_id;
    }

    public function broadcastOn()
    {
        return new Channel('community.' . $this->communityId);
    }

    public function broadcastAs()
    {
        return 'new-post';
    }
    public function broadcastWith()
    {
        return [
            'post' => $this->post,
            'html' => $this->html,
            'communityId' => $this->communityId,
            'timestamp' => now()->toDateTimeString()
        ];
    }
}
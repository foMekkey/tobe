<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Comment;

class NewComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $html;
    public $communityId;
    public $postId;

    public function __construct(Comment $comment, $html)
    {
        $this->comment = $comment;
        $this->html = $html;
        $this->postId = $comment->post_id;
        $this->communityId = $comment->post->community_id;
    }

    public function broadcastOn()
    {
        return new Channel('community.' . $this->communityId);
    }

    public function broadcastAs()
    {
        return 'new-comment';
    }
}
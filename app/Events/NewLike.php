<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLike implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $likeableId;
    public $likeableType;
    public $likesCount;
    public $communityId;

    public function __construct($likeableId, $likeableType, $likesCount, $communityId)
    {
        $this->likeableId = $likeableId;
        $this->likeableType = $likeableType;
        $this->likesCount = $likesCount;
        $this->communityId = $communityId;
    }

    public function broadcastOn()
    {
        return new Channel('community.' . $this->communityId);
    }

    public function broadcastAs()
    {
        return 'new-like';
    }
}
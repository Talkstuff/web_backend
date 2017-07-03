<?php

namespace Modules\Posts\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Posts\Models\Post;

class PostWasAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Post
     */
    public $post;
    /**
     * @var array
     */
    public $payLoadData;

    /**
     * Create a new event instance.
     * @param Post $post
     * @param array $payLoadData
     */
    public function __construct(Post $post, array $payLoadData)
    {
        //
        $this->post = $post;
        $this->payLoadData = $payLoadData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

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

class PostStatusWasToggled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Post
     */
    public $post;
    /**
     * @var array
     */
    public $user_id;

    /**
     * Create a new event instance.
     * @param Post $post
     * @param $user_id
     */
    public function __construct(Post $post, $user_id)
    {
        //
        $this->post = $post;
        $this->user_id = $user_id;
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

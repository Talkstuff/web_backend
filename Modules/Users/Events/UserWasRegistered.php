<?php

namespace Modules\Users\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Users\Models\User;

class UserWasRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public $user;
    /**
     * @var array
     */
    public $payLoadData;

    /**
     * Create a new event instance.
     * @param User $user
     * @param array $payLoadData
     */
    public function __construct(User $user, array $payLoadData)
    {
        //
        $this->user = $user;
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

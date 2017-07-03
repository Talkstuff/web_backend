<?php

namespace Modules\Staff\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Member\Models\Member;
use Modules\Security\Models\User;
use Modules\Staff\Models\Staff;

class StaffWasAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Staff
     */
    public $staff;
    /**
     * @var array
     */
    public $payLoadData;

    /**
     * Create a new event instance.
     * @param Staff $staff
     * @param array $payLoadData
     */
    public function __construct(Staff $staff, array $payLoadData)
    {
        //
        $this->staff = $staff;
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

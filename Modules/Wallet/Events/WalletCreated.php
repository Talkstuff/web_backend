<?php
/**
 * Created by PhpStorm.
 * User: Godwin
 * Date: 6/12/2017
 * Time: 11:32 AM
 */

namespace Modules\Wallet\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Wallet\Models\Wallet;

class WalletCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Wallet
     */
    public $Wallet;
    /**
     * @var array
     */
    public $payLoadData;

    /**
     * Create a new event instance.
     * @param Wallet $Wallet
     * @param array $payLoadData
     */
    public function __construct(Wallet $Wallet, array $payLoadData)
    {
        //
        $this->wallet = $Wallet;
        $this->payLoadData = $payLoadData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('Wallet');
    }
}